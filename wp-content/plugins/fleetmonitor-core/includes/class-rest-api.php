<?php
/**
 * REST API endpoints for fleet data.
 *
 * @package FleetMonitor_Core
 */

defined( 'ABSPATH' ) || exit;

class FleetMonitor_REST_API {

	const NAMESPACE = 'fleetmonitor/v1';

	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
	}

	public static function register_routes() {
		// Fleet dashboard summary
		register_rest_route(
			self::NAMESPACE,
			'/dashboard',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'get_dashboard' ),
				'permission_callback' => array( __CLASS__, 'check_auth' ),
			)
		);

		// Vehicles list
		register_rest_route(
			self::NAMESPACE,
			'/vehicles',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'get_vehicles' ),
				'permission_callback' => array( __CLASS__, 'check_auth' ),
				'args'                => array(
					'status' => array(
						'type'     => 'string',
						'enum'     => array( 'active', 'idle', 'offline', 'all' ),
						'default'  => 'all',
					),
					'per_page' => array(
						'type'    => 'integer',
						'default' => 20,
						'minimum' => 1,
						'maximum' => 100,
					),
					'page' => array(
						'type'    => 'integer',
						'default' => 1,
						'minimum' => 1,
					),
				),
			)
		);

		// Single vehicle
		register_rest_route(
			self::NAMESPACE,
			'/vehicles/(?P<id>[\d]+)',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'get_vehicle' ),
				'permission_callback' => array( __CLASS__, 'check_auth' ),
				'args'                => array(
					'id' => array(
						'type'     => 'integer',
						'required' => true,
					),
				),
			)
		);

		// Update vehicle position (webhook from GPS device)
		register_rest_route(
			self::NAMESPACE,
			'/vehicles/(?P<id>[\d]+)/position',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( __CLASS__, 'update_position' ),
				'permission_callback' => array( __CLASS__, 'check_device_auth' ),
				'args'                => array(
					'id'  => array( 'type' => 'integer', 'required' => true ),
					'lat' => array( 'type' => 'number',  'required' => true ),
					'lng' => array( 'type' => 'number',  'required' => true ),
					'speed'   => array( 'type' => 'number', 'default' => 0 ),
					'heading' => array( 'type' => 'number', 'default' => 0 ),
					'alt'     => array( 'type' => 'number', 'default' => 0 ),
					'ts'      => array( 'type' => 'string', 'default' => '' ),
				),
			)
		);

		// Fleet stats
		register_rest_route(
			self::NAMESPACE,
			'/stats',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'get_stats' ),
				'permission_callback' => array( __CLASS__, 'check_auth' ),
			)
		);
	}

	// --------------------------------------------------------
	// PERMISSION CALLBACKS
	// --------------------------------------------------------

	public static function check_auth( WP_REST_Request $request ) {
		// Require logged-in user or valid API key in header
		if ( is_user_logged_in() ) {
			return current_user_can( 'read' );
		}

		$api_key = $request->get_header( 'X-FleetMonitor-Key' );
		if ( $api_key ) {
			return self::validate_api_key( sanitize_text_field( $api_key ) );
		}

		return new WP_Error( 'rest_forbidden', esc_html__( 'Authentication required.', 'fleetmonitor-core' ), array( 'status' => 401 ) );
	}

	public static function check_device_auth( WP_REST_Request $request ) {
		$device_key = $request->get_header( 'X-Device-Key' );
		if ( ! $device_key ) {
			$device_key = $request->get_param( 'device_key' );
		}

		if ( empty( $device_key ) ) {
			return new WP_Error( 'rest_forbidden', esc_html__( 'Device authentication required.', 'fleetmonitor-core' ), array( 'status' => 401 ) );
		}

		return self::validate_device_key( sanitize_text_field( $device_key ) );
	}

	private static function validate_api_key( string $key ): bool {
		$stored_keys = get_option( 'fm_api_keys', array() );
		return in_array( hash( 'sha256', $key ), array_column( $stored_keys, 'hash' ), true );
	}

	private static function validate_device_key( string $key ): bool {
		// Look up device key across vehicles
		$vehicles = get_posts(
			array(
				'post_type'   => 'fm_vehicle',
				'numberposts' => -1,
				'post_status' => 'publish',
				'meta_key'    => '_vehicle_device_key', // phpcs:ignore WordPress.DB.SlowDBQuery
				'meta_value'  => hash( 'sha256', $key ), // phpcs:ignore WordPress.DB.SlowDBQuery
			)
		);
		return ! empty( $vehicles );
	}

	// --------------------------------------------------------
	// ENDPOINT CALLBACKS
	// --------------------------------------------------------

	public static function get_dashboard( WP_REST_Request $request ): WP_REST_Response {
		$vehicles = get_posts(
			array(
				'post_type'   => 'fm_vehicle',
				'numberposts' => -1,
				'post_status' => 'publish',
			)
		);

		$total    = count( $vehicles );
		$active   = 0;
		$idle     = 0;
		$offline  = 0;
		$alerts   = 0;

		foreach ( $vehicles as $v ) {
			$status  = get_post_meta( $v->ID, '_vehicle_status', true );
			$speed   = (float) get_post_meta( $v->ID, '_vehicle_speed', true );
			$updated = get_post_meta( $v->ID, '_vehicle_last_updated', true );

			// Determine real-time status
			if ( $updated ) {
				$diff = time() - strtotime( $updated );
				if ( $diff > 3600 ) {
					$offline++;
				} elseif ( $speed > 0 ) {
					$active++;
				} else {
					$idle++;
				}
			} else {
				$offline++;
			}

			if ( 'Geofence Alert' === $status ) {
				$alerts++;
			}
		}

		return new WP_REST_Response(
			array(
				'total_vehicles' => $total,
				'active'         => $active,
				'idle'           => $idle,
				'offline'        => $offline,
				'alerts'         => $alerts,
				'timestamp'      => gmdate( 'c' ),
			),
			200
		);
	}

	public static function get_vehicles( WP_REST_Request $request ): WP_REST_Response {
		$status   = $request->get_param( 'status' );
		$per_page = (int) $request->get_param( 'per_page' );
		$page     = (int) $request->get_param( 'page' );

		$args = array(
			'post_type'      => 'fm_vehicle',
			'posts_per_page' => $per_page,
			'paged'          => $page,
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		$query = new WP_Query( $args );
		$data  = array();

		foreach ( $query->posts as $post ) {
			$data[] = self::format_vehicle( $post );
		}

		$response = new WP_REST_Response( $data, 200 );
		$response->header( 'X-Total-Count', (string) $query->found_posts );
		$response->header( 'X-Total-Pages', (string) $query->max_num_pages );

		return $response;
	}

	public static function get_vehicle( WP_REST_Request $request ): WP_REST_Response {
		$id   = (int) $request->get_param( 'id' );
		$post = get_post( $id );

		if ( ! $post || 'fm_vehicle' !== $post->post_type ) {
			return new WP_REST_Response( array( 'message' => 'Vehicle not found.' ), 404 );
		}

		return new WP_REST_Response( self::format_vehicle( $post ), 200 );
	}

	public static function update_position( WP_REST_Request $request ): WP_REST_Response {
		$id      = (int) $request->get_param( 'id' );
		$lat     = (float) $request->get_param( 'lat' );
		$lng     = (float) $request->get_param( 'lng' );
		$speed   = (float) $request->get_param( 'speed' );
		$heading = (float) $request->get_param( 'heading' );
		$alt     = (float) $request->get_param( 'alt' );
		$ts      = sanitize_text_field( $request->get_param( 'ts' ) ) ?: gmdate( 'c' );

		$post = get_post( $id );
		if ( ! $post || 'fm_vehicle' !== $post->post_type ) {
			return new WP_REST_Response( array( 'message' => 'Vehicle not found.' ), 404 );
		}

		// Validate coordinates
		if ( $lat < -90 || $lat > 90 || $lng < -180 || $lng > 180 ) {
			return new WP_REST_Response( array( 'message' => 'Invalid coordinates.' ), 400 );
		}

		update_post_meta( $id, '_vehicle_lat', $lat );
		update_post_meta( $id, '_vehicle_lng', $lng );
		update_post_meta( $id, '_vehicle_speed', $speed );
		update_post_meta( $id, '_vehicle_heading', $heading );
		update_post_meta( $id, '_vehicle_altitude', $alt );
		update_post_meta( $id, '_vehicle_last_updated', $ts );

		// Log position in history (append to array, keep last 1000 points)
		$history   = get_post_meta( $id, '_vehicle_position_history', true );
		$history   = is_array( $history ) ? $history : array();
		$history[] = array( 'lat' => $lat, 'lng' => $lng, 'spd' => $speed, 'ts' => $ts );

		if ( count( $history ) > 1000 ) {
			$history = array_slice( $history, -1000 );
		}

		update_post_meta( $id, '_vehicle_position_history', $history );

		return new WP_REST_Response(
			array(
				'success'   => true,
				'vehicle_id'=> $id,
				'position'  => array( 'lat' => $lat, 'lng' => $lng ),
				'timestamp' => $ts,
			),
			200
		);
	}

	public static function get_stats( WP_REST_Request $request ): WP_REST_Response {
		$vehicle_count = wp_count_posts( 'fm_vehicle' )->publish;
		$fleet_count   = wp_count_posts( 'fm_fleet' )->publish;

		return new WP_REST_Response(
			array(
				'vehicles' => (int) $vehicle_count,
				'fleets'   => (int) $fleet_count,
				'platform' => array(
					'version'      => FM_CORE_VERSION,
					'wordpress'    => get_bloginfo( 'version' ),
					'woocommerce'  => defined( 'WC_VERSION' ) ? WC_VERSION : null,
					'php'          => PHP_VERSION,
				),
			),
			200
		);
	}

	// --------------------------------------------------------
	// FORMAT HELPERS
	// --------------------------------------------------------

	private static function format_vehicle( WP_Post $post ): array {
		$meta_keys = array(
			'_vehicle_plate', '_vehicle_make', '_vehicle_model', '_vehicle_year',
			'_vehicle_vin', '_vehicle_fuel_type', '_vehicle_mileage', '_vehicle_driver',
			'_vehicle_gps_id', '_vehicle_lat', '_vehicle_lng', '_vehicle_speed',
			'_vehicle_heading', '_vehicle_altitude', '_vehicle_last_updated',
			'_vehicle_insurance', '_vehicle_service',
		);

		$meta = array();
		foreach ( $meta_keys as $key ) {
			$clean_key         = ltrim( $key, '_' );
			$meta[ $clean_key ] = get_post_meta( $post->ID, $key, true );
		}

		return array(
			'id'          => $post->ID,
			'title'       => $post->post_title,
			'excerpt'     => $post->post_excerpt,
			'status'      => $post->post_status,
			'created_at'  => $post->post_date_gmt,
			'updated_at'  => $post->post_modified_gmt,
			'permalink'   => get_permalink( $post->ID ),
			'thumbnail'   => get_the_post_thumbnail_url( $post->ID, 'thumbnail' ),
			'vehicle'     => $meta,
			'vehicle_type' => wp_get_post_terms( $post->ID, 'vehicle_type', array( 'fields' => 'names' ) ),
		);
	}
}
