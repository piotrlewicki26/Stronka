<?php
/**
 * Vehicle post type and taxonomy registration.
 *
 * @package FleetLink_Core
 */

defined( 'ABSPATH' ) || exit;

class FleetLink_Vehicles {

	/**
	 * Initialise hooks.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 5 );
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
		add_action( 'save_post_fm_vehicle', array( __CLASS__, 'save_meta' ), 10, 2 );
	}

	// ----------------------------------------------------------
	// POST TYPES
	// ----------------------------------------------------------

	public static function register_post_types() {
		// Vehicle
		register_post_type(
			'fm_vehicle',
			array(
				'labels'              => array(
					'name'               => _x( 'Vehicles', 'CPT general name', 'fleetmonitor-core' ),
					'singular_name'      => _x( 'Vehicle', 'CPT singular name', 'fleetmonitor-core' ),
					'add_new'            => __( 'Add New', 'fleetmonitor-core' ),
					'add_new_item'       => __( 'Add New Vehicle', 'fleetmonitor-core' ),
					'edit_item'          => __( 'Edit Vehicle', 'fleetmonitor-core' ),
					'new_item'           => __( 'New Vehicle', 'fleetmonitor-core' ),
					'view_item'          => __( 'View Vehicle', 'fleetmonitor-core' ),
					'search_items'       => __( 'Search Vehicles', 'fleetmonitor-core' ),
					'not_found'          => __( 'No vehicles found', 'fleetmonitor-core' ),
					'not_found_in_trash' => __( 'No vehicles found in Trash', 'fleetmonitor-core' ),
				),
				'public'              => true,
				'has_archive'         => true,
				'menu_icon'           => 'dashicons-car',
				'menu_position'       => 25,
				'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ),
				'show_in_rest'        => true,
				'rest_base'           => 'vehicles',
				'rewrite'             => array( 'slug' => 'vehicles', 'with_front' => false ),
				'capability_type'     => 'post',
				'map_meta_cap'        => true,
			)
		);

		// Fleet
		register_post_type(
			'fm_fleet',
			array(
				'labels'              => array(
					'name'          => _x( 'Fleets', 'CPT general name', 'fleetmonitor-core' ),
					'singular_name' => _x( 'Fleet', 'CPT singular name', 'fleetmonitor-core' ),
					'add_new_item'  => __( 'Add New Fleet', 'fleetmonitor-core' ),
					'edit_item'     => __( 'Edit Fleet', 'fleetmonitor-core' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'menu_icon'     => 'dashicons-groups',
				'menu_position' => 26,
				'supports'      => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
				'show_in_rest'  => true,
				'rest_base'     => 'fleets',
				'rewrite'       => array( 'slug' => 'fleets', 'with_front' => false ),
			)
		);

		// Testimonial
		register_post_type(
			'fm_testimonial',
			array(
				'labels'        => array(
					'name'          => _x( 'Testimonials', 'CPT general name', 'fleetmonitor-core' ),
					'singular_name' => _x( 'Testimonial', 'CPT singular name', 'fleetmonitor-core' ),
					'add_new_item'  => __( 'Add New Testimonial', 'fleetmonitor-core' ),
					'edit_item'     => __( 'Edit Testimonial', 'fleetmonitor-core' ),
				),
				'public'        => false,
				'show_ui'       => true,
				'menu_icon'     => 'dashicons-format-quote',
				'menu_position' => 27,
				'supports'      => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
				'show_in_rest'  => true,
			)
		);
	}

	// ----------------------------------------------------------
	// TAXONOMIES
	// ----------------------------------------------------------

	public static function register_taxonomies() {
		// Vehicle Type
		register_taxonomy(
			'vehicle_type',
			array( 'fm_vehicle' ),
			array(
				'labels'       => array(
					'name'          => _x( 'Vehicle Types', 'taxonomy', 'fleetmonitor-core' ),
					'singular_name' => _x( 'Vehicle Type', 'taxonomy', 'fleetmonitor-core' ),
					'search_items'  => __( 'Search Vehicle Types', 'fleetmonitor-core' ),
					'all_items'     => __( 'All Vehicle Types', 'fleetmonitor-core' ),
					'edit_item'     => __( 'Edit Vehicle Type', 'fleetmonitor-core' ),
					'add_new_item'  => __( 'Add New Vehicle Type', 'fleetmonitor-core' ),
				),
				'hierarchical' => true,
				'show_in_rest' => true,
				'rewrite'      => array( 'slug' => 'vehicle-type' ),
			)
		);

		// Vehicle Status
		register_taxonomy(
			'vehicle_status',
			array( 'fm_vehicle' ),
			array(
				'labels'       => array(
					'name'          => _x( 'Vehicle Status', 'taxonomy', 'fleetmonitor-core' ),
					'singular_name' => _x( 'Status', 'taxonomy', 'fleetmonitor-core' ),
					'add_new_item'  => __( 'Add New Status', 'fleetmonitor-core' ),
				),
				'hierarchical' => false,
				'show_in_rest' => true,
				'rewrite'      => array( 'slug' => 'vehicle-status' ),
			)
		);
	}

	// ----------------------------------------------------------
	// META BOXES
	// ----------------------------------------------------------

	public static function add_meta_boxes() {
		add_meta_box(
			'fm_vehicle_details',
			__( 'Vehicle Details', 'fleetmonitor-core' ),
			array( __CLASS__, 'render_vehicle_meta_box' ),
			'fm_vehicle',
			'normal',
			'high'
		);

		add_meta_box(
			'fm_testimonial_meta',
			__( 'Testimonial Details', 'fleetmonitor-core' ),
			array( __CLASS__, 'render_testimonial_meta_box' ),
			'fm_testimonial',
			'normal',
			'high'
		);
	}

	public static function render_vehicle_meta_box( $post ) {
		wp_nonce_field( 'fm_vehicle_meta_save', 'fm_vehicle_meta_nonce' );

		$fields = array(
			'_vehicle_plate'       => __( 'Registration Plate', 'fleetmonitor-core' ),
			'_vehicle_make'        => __( 'Make / Brand', 'fleetmonitor-core' ),
			'_vehicle_model'       => __( 'Model', 'fleetmonitor-core' ),
			'_vehicle_year'        => __( 'Year', 'fleetmonitor-core' ),
			'_vehicle_vin'         => __( 'VIN Number', 'fleetmonitor-core' ),
			'_vehicle_fuel_type'   => __( 'Fuel Type', 'fleetmonitor-core' ),
			'_vehicle_mileage'     => __( 'Current Mileage (km)', 'fleetmonitor-core' ),
			'_vehicle_driver'      => __( 'Assigned Driver', 'fleetmonitor-core' ),
			'_vehicle_gps_id'      => __( 'GPS Device ID', 'fleetmonitor-core' ),
			'_vehicle_sim'         => __( 'SIM / IMEI', 'fleetmonitor-core' ),
			'_vehicle_lat'         => __( 'Last Known Latitude', 'fleetmonitor-core' ),
			'_vehicle_lng'         => __( 'Last Known Longitude', 'fleetmonitor-core' ),
			'_vehicle_speed'       => __( 'Last Speed (km/h)', 'fleetmonitor-core' ),
			'_vehicle_insurance'   => __( 'Insurance Expiry (YYYY-MM-DD)', 'fleetmonitor-core' ),
			'_vehicle_service'     => __( 'Next Service Date (YYYY-MM-DD)', 'fleetmonitor-core' ),
		);

		echo '<table class="form-table" style="width:100%;">';
		foreach ( $fields as $key => $label ) {
			$value = get_post_meta( $post->ID, $key, true );
			printf(
				'<tr><th style="width:180px; padding:.75rem .5rem;"><label for="%s">%s</label></th>
				<td style="padding:.5rem;"><input type="text" id="%s" name="%s" value="%s" style="width:100%%; max-width:400px;" class="regular-text"></td></tr>',
				esc_attr( $key ),
				esc_html( $label ),
				esc_attr( $key ),
				esc_attr( $key ),
				esc_attr( $value )
			);
		}
		echo '</table>';
	}

	public static function render_testimonial_meta_box( $post ) {
		wp_nonce_field( 'fm_testimonial_meta_save', 'fm_testimonial_meta_nonce' );
		$fields = array(
			'_testimonial_role'    => __( 'Role / Company', 'fleetmonitor-core' ),
			'_testimonial_rating'  => __( 'Rating (1–5)', 'fleetmonitor-core' ),
			'_testimonial_company' => __( 'Company Name', 'fleetmonitor-core' ),
			'_testimonial_website' => __( 'Website URL', 'fleetmonitor-core' ),
		);

		echo '<table class="form-table" style="width:100%;">';
		foreach ( $fields as $key => $label ) {
			$value = get_post_meta( $post->ID, $key, true );
			printf(
				'<tr><th><label for="%s">%s</label></th>
				<td><input type="text" id="%s" name="%s" value="%s" class="regular-text" style="width:100%%"></td></tr>',
				esc_attr( $key ),
				esc_html( $label ),
				esc_attr( $key ),
				esc_attr( $key ),
				esc_attr( $value )
			);
		}
		echo '</table>';
	}

	// ----------------------------------------------------------
	// SAVE META
	// ----------------------------------------------------------

	public static function save_meta( $post_id, $post ) {
		// Verify nonce
		if (
			! isset( $_POST['fm_vehicle_meta_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fm_vehicle_meta_nonce'] ) ), 'fm_vehicle_meta_save' )
		) {
			return;
		}

		// Bail on auto-save
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$vehicle_fields = array(
			'_vehicle_plate', '_vehicle_make', '_vehicle_model', '_vehicle_year',
			'_vehicle_vin', '_vehicle_fuel_type', '_vehicle_mileage', '_vehicle_driver',
			'_vehicle_gps_id', '_vehicle_sim', '_vehicle_lat', '_vehicle_lng',
			'_vehicle_speed', '_vehicle_insurance', '_vehicle_service',
		);

		foreach ( $vehicle_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			}
		}
	}

	// ----------------------------------------------------------
	// ACTIVATION HOOK
	// ----------------------------------------------------------

	public static function on_activate() {
		self::register_post_types();
		self::register_taxonomies();
		flush_rewrite_rules();

		// Insert default vehicle types if not present
		$types = array( 'Truck', 'Van', 'Car', 'Motorcycle', 'Bus', 'Trailer', 'Construction' );
		foreach ( $types as $type_name ) {
			if ( ! term_exists( $type_name, 'vehicle_type' ) ) {
				wp_insert_term( $type_name, 'vehicle_type' );
			}
		}

		// Insert default vehicle statuses
		$statuses = array( 'Active', 'Idle', 'Maintenance', 'Offline', 'Geofence Alert' );
		foreach ( $statuses as $status_name ) {
			if ( ! term_exists( $status_name, 'vehicle_status' ) ) {
				wp_insert_term( $status_name, 'vehicle_status' );
			}
		}

		// Set a flag for admin notice on first activation
		set_transient( 'fm_core_activated', true, 60 );
	}

	public static function on_deactivate() {
		flush_rewrite_rules();
	}
}
