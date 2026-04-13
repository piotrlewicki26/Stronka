<?php
/**
 * WooCommerce integration class.
 * Handles product categories, custom product data and sample products.
 *
 * @package FleetMonitor_Core
 */

defined( 'ABSPATH' ) || exit;

class FleetMonitor_WooCommerce {

	public static function init() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			add_action( 'admin_notices', array( __CLASS__, 'woo_missing_notice' ) );
			return;
		}

		add_action( 'init', array( __CLASS__, 'maybe_create_sample_products' ) );
		add_filter( 'woocommerce_product_tabs', array( __CLASS__, 'add_gps_specs_tab' ) );
		add_action( 'woocommerce_gps_specs_tab_content', array( __CLASS__, 'render_gps_specs_tab' ) );
		add_action( 'woocommerce_product_options_general_product_data', array( __CLASS__, 'add_gps_product_fields' ) );
		add_action( 'woocommerce_process_product_meta', array( __CLASS__, 'save_gps_product_fields' ) );
		add_filter( 'woocommerce_email_order_items_args', array( __CLASS__, 'customise_email_items' ) );
	}

	// --------------------------------------------------------
	// ADMIN NOTICE IF WOO IS MISSING
	// --------------------------------------------------------

	public static function woo_missing_notice() {
		?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<?php
				printf(
					/* translators: %s: WooCommerce */
					esc_html__( 'FleetMonitor Core: %s is required for full shop functionality.', 'fleetmonitor-core' ),
					'<strong>WooCommerce</strong>'
				);
				?>
			</p>
		</div>
		<?php
	}

	// --------------------------------------------------------
	// GPS SPECS PRODUCT TAB
	// --------------------------------------------------------

	public static function add_gps_specs_tab( $tabs ) {
		global $product;
		if ( ! $product ) {
			return $tabs;
		}

		// Only show the tab if GPS specs are configured
		$specs = get_post_meta( $product->get_id(), '_gps_specs', true );
		if ( empty( $specs ) ) {
			return $tabs;
		}

		$tabs['gps_specs'] = array(
			'title'    => __( 'Technical Specifications', 'fleetmonitor-core' ),
			'priority' => 25,
			'callback' => array( __CLASS__, 'render_gps_specs_tab' ),
		);

		return $tabs;
	}

	public static function render_gps_specs_tab() {
		global $product;
		if ( ! $product ) {
			return;
		}

		$specs_raw = get_post_meta( $product->get_id(), '_gps_specs', true );
		if ( empty( $specs_raw ) ) {
			return;
		}

		$specs = array_filter( array_map( 'trim', explode( "\n", $specs_raw ) ) );

		echo '<h2>' . esc_html__( 'Technical Specifications', 'fleetmonitor-core' ) . '</h2>';
		echo '<table class="shop_attributes" style="width:100%;">';

		foreach ( $specs as $spec_line ) {
			if ( strpos( $spec_line, ':' ) !== false ) {
				list( $label, $value ) = explode( ':', $spec_line, 2 );
				printf(
					'<tr><th>%s</th><td>%s</td></tr>',
					esc_html( trim( $label ) ),
					wp_kses_post( trim( $value ) )
				);
			}
		}

		echo '</table>';
	}

	// --------------------------------------------------------
	// CUSTOM PRODUCT FIELDS (GPS meta)
	// --------------------------------------------------------

	public static function add_gps_product_fields() {
		echo '<div class="options_group">';
		echo '<h4 style="padding-left:12px; color:#23282d;">' . esc_html__( 'GPS Device Specifications', 'fleetmonitor-core' ) . '</h4>';

		woocommerce_wp_text_input(
			array(
				'id'          => '_gps_device_id',
				'label'       => __( 'GPS Device ID / Model', 'fleetmonitor-core' ),
				'placeholder' => 'e.g. FMB920',
				'desc_tip'    => true,
				'description' => __( 'Unique identifier or model number for this GPS device.', 'fleetmonitor-core' ),
			)
		);

		woocommerce_wp_select(
			array(
				'id'          => '_gps_connectivity',
				'label'       => __( 'Connectivity', 'fleetmonitor-core' ),
				'options'     => array(
					''          => __( '-- Select --', 'fleetmonitor-core' ),
					'2G'        => '2G (GSM/GPRS)',
					'3G'        => '3G (UMTS)',
					'4G'        => '4G LTE',
					'4G+WiFi'   => '4G LTE + Wi-Fi',
					'bluetooth' => 'Bluetooth Only',
					'satellite' => 'Satellite (Global)',
				),
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => '_gps_accuracy',
				'label'       => __( 'GPS Accuracy', 'fleetmonitor-core' ),
				'placeholder' => 'e.g. < 3m CEP',
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => '_gps_battery',
				'label'       => __( 'Battery Life', 'fleetmonitor-core' ),
				'placeholder' => 'e.g. 7 days standby',
			)
		);

		woocommerce_wp_select(
			array(
				'id'      => '_gps_waterproof',
				'label'   => __( 'Waterproof Rating', 'fleetmonitor-core' ),
				'options' => array(
					''      => __( '-- Select --', 'fleetmonitor-core' ),
					'IP54'  => 'IP54',
					'IP65'  => 'IP65',
					'IP67'  => 'IP67',
					'IP68'  => 'IP68',
					'none'  => __( 'Not waterproof', 'fleetmonitor-core' ),
				),
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => '_gps_install_type',
				'label'       => __( 'Installation Type', 'fleetmonitor-core' ),
				'placeholder' => 'e.g. OBD plug-in, wired, magnetic',
			)
		);

		woocommerce_wp_textarea_input(
			array(
				'id'          => '_gps_specs',
				'label'       => __( 'Full Spec Sheet', 'fleetmonitor-core' ),
				'placeholder' => "Chip: u-blox M8N\nUpdate rate: 5s\nOperating temp: -40°C to +85°C",
				'description' => __( 'One spec per line, in format: Label: Value', 'fleetmonitor-core' ),
				'desc_tip'    => true,
			)
		);

		echo '</div>';
	}

	public static function save_gps_product_fields( $post_id ) {
		$fields = array(
			'_gps_device_id',
			'_gps_connectivity',
			'_gps_accuracy',
			'_gps_battery',
			'_gps_waterproof',
			'_gps_install_type',
			'_gps_specs',
		);

		foreach ( $fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				update_post_meta(
					$post_id,
					$field,
					sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) // phpcs:ignore WordPress.Security.NonceVerification
				);
			}
		}
	}

	// --------------------------------------------------------
	// EMAIL CUSTOMISATION
	// --------------------------------------------------------

	public static function customise_email_items( $args ) {
		$args['show_sku']   = true;
		$args['show_image'] = true;
		return $args;
	}

	// --------------------------------------------------------
	// SAMPLE PRODUCTS
	// --------------------------------------------------------

	/**
	 * Create sample products on first activation if Woo is active and no products exist.
	 * Only runs once, controlled by an option flag.
	 */
	public static function maybe_create_sample_products() {
		if ( get_option( 'fm_sample_products_created' ) ) {
			return;
		}

		// Only create if no products exist at all
		$existing = get_posts(
			array(
				'post_type'   => 'product',
				'numberposts' => 1,
				'post_status' => 'any',
			)
		);

		if ( ! empty( $existing ) ) {
			update_option( 'fm_sample_products_created', true );
			return;
		}

		self::create_sample_products();
		update_option( 'fm_sample_products_created', true );
	}

	private static function create_sample_products() {
		if ( ! function_exists( 'wc_get_product' ) ) {
			return;
		}

		// Ensure product categories exist
		$cat_map = array();
		$categories = array(
			'gps-trackers'     => array( 'name' => 'GPS Trackers',         'desc' => 'Professional GPS tracking devices for vehicles, assets and people.' ),
			'obd-devices'      => array( 'name' => 'OBD Devices',          'desc' => 'Plug-in OBD-II GPS trackers and diagnostic dongles.' ),
			'dashcams'         => array( 'name' => 'Dashcams',             'desc' => 'HD and 4K dashboard cameras with GPS logging.' ),
			'fleet-software'   => array( 'name' => 'Fleet Software',       'desc' => 'SaaS fleet management subscriptions.' ),
			'accessories'      => array( 'name' => 'Accessories',          'desc' => 'GPS tracker accessories, mounts, cables and SIM cards.' ),
		);

		foreach ( $categories as $slug => $data ) {
			$term = get_term_by( 'slug', $slug, 'product_cat' );
			if ( ! $term ) {
				$result = wp_insert_term(
					$data['name'],
					'product_cat',
					array(
						'slug'        => $slug,
						'description' => $data['desc'],
					)
				);
				$cat_map[ $slug ] = ! is_wp_error( $result ) ? $result['term_id'] : 0;
			} else {
				$cat_map[ $slug ] = $term->term_id;
			}
		}

		// Sample product data
		$products = array(
			array(
				'name'          => 'FleetTrack Pro X200',
				'price'         => '299.99',
				'sale_price'    => '',
				'description'   => '<p>The FleetTrack Pro X200 is our flagship 4G LTE GPS tracker designed for professional fleet management. With a built-in 3,000 mAh battery providing up to 7 days of standby, IP67 waterproof housing, and real-time updates every 5 seconds, it is the ultimate tool for tracking commercial vehicles.</p><ul><li>4G LTE connectivity with 2G fallback</li><li>Real-time position every 5 seconds</li><li>IP67 waterproof and dustproof</li><li>Built-in accelerometer for motion detection</li><li>Geofencing and speed alerts</li><li>Compatible with FleetMonitor Pro platform</li></ul>',
				'short_desc'    => '4G LTE professional GPS vehicle tracker with 7-day battery, IP67 waterproofing and real-time tracking.',
				'cats'          => array( 'gps-trackers' ),
				'sku'           => 'FM-X200',
				'tags'          => array( 'GPS', '4G', 'Waterproof', 'Fleet' ),
				'featured'      => true,
				'gps_fields'    => array(
					'_gps_device_id'     => 'FleetTrack Pro X200',
					'_gps_connectivity'  => '4G',
					'_gps_accuracy'      => '< 2.5m CEP',
					'_gps_battery'       => '7 days standby',
					'_gps_waterproof'    => 'IP67',
					'_gps_install_type'  => 'Wired (hardwired to vehicle)',
					'_gps_specs'         => "Chip: u-blox M8N\nConnectivity: 4G LTE + 2G fallback\nUpdate rate: 5 seconds\nBattery: 3000 mAh Li-ion\nGPS Accuracy: < 2.5m CEP\nOperating temp: -40°C to +85°C\nWaterproof: IP67\nWeight: 98g\nDimensions: 80 × 40 × 20 mm",
				),
			),
			array(
				'name'          => 'OBD Connect Elite',
				'price'         => '149.99',
				'sale_price'    => '119.99',
				'description'   => '<p>The OBD Connect Elite plugs directly into your vehicle\'s OBD-II port for instant, tool-free installation. It provides real-time GPS tracking, engine diagnostics, fuel monitoring and driver behaviour analysis.</p><ul><li>Plug-and-play OBD-II installation</li><li>Real-time GPS + engine data</li><li>Fuel consumption monitoring</li><li>DTCs (fault code) reading</li><li>4G LTE connectivity</li></ul>',
				'short_desc'    => 'Plug-in OBD-II GPS tracker with engine diagnostics and fuel monitoring. No installation required.',
				'cats'          => array( 'obd-devices' ),
				'sku'           => 'FM-OBD-ELITE',
				'tags'          => array( 'OBD', 'GPS', '4G', 'Fleet' ),
				'featured'      => true,
				'gps_fields'    => array(
					'_gps_device_id'    => 'OBD Connect Elite',
					'_gps_connectivity' => '4G',
					'_gps_accuracy'     => '< 3m CEP',
					'_gps_waterproof'   => 'none',
					'_gps_install_type' => 'OBD-II plug-in (no tools needed)',
					'_gps_specs'        => "Connector: OBD-II (J1962)\nConnectivity: 4G LTE\nUpdate rate: 30 seconds\nGPS Accuracy: < 3m CEP\nOperating temp: -20°C to +70°C\nDimensions: 62 × 34 × 22 mm\nWeight: 45g",
				),
			),
			array(
				'name'          => 'DriveSafe 4K Dashcam',
				'price'         => '219.99',
				'sale_price'    => '179.99',
				'description'   => '<p>The DriveSafe 4K is a professional dual-channel dashcam (front + interior) with built-in GPS logging, G-sensor and cloud upload. Ideal for proof-of-delivery, insurance evidence and driver monitoring.</p><ul><li>4K front camera, Full HD interior camera</li><li>Built-in GPS logging</li><li>G-sensor for automatic incident detection</li><li>Night vision with Sony Starvis sensor</li><li>Cloud auto-upload via 4G hotspot</li><li>Parking mode protection</li></ul>',
				'short_desc'    => 'Dual-lens 4K dashcam with GPS logging, G-sensor, night vision and cloud upload for fleet vehicles.',
				'cats'          => array( 'dashcams' ),
				'sku'           => 'FM-DASH-4K',
				'tags'          => array( '4K', 'Dashcam', 'GPS', 'Fleet' ),
				'featured'      => true,
				'gps_fields'    => array(
					'_gps_device_id'    => 'DriveSafe 4K',
					'_gps_connectivity' => '4G+WiFi',
					'_gps_accuracy'     => 'GPS embedded (< 5m)',
					'_gps_waterproof'   => 'none',
					'_gps_install_type' => 'Windshield mount + hardwire kit',
					'_gps_specs'        => "Front Camera: 4K @ 30fps\nInterior Camera: 1080p @ 30fps\nGPS: Built-in, GLONASS\nStorage: 128GB microSD (included)\nConnectivity: 4G LTE / Wi-Fi\nG-sensor: 3-axis\nNight Vision: Sony Starvis IMX335\nOperating temp: -20°C to +70°C",
				),
			),
			array(
				'name'          => 'FleetMonitor SaaS Pro – Monthly',
				'price'         => '79.99',
				'sale_price'    => '',
				'description'   => '<p>The FleetMonitor SaaS Pro subscription gives you full access to the professional fleet management platform for up to 25 vehicles. Includes real-time tracking, route optimisation, driver behaviour monitoring, maintenance management and unlimited reports.</p><p><strong>Subscription includes:</strong></p><ul><li>Up to 25 vehicles</li><li>Real-time GPS tracking</li><li>Driver behaviour analytics</li><li>Route optimisation</li><li>Maintenance scheduling</li><li>Unlimited reports & exports</li><li>Mobile apps (iOS + Android)</li><li>Priority email support</li></ul>',
				'short_desc'    => 'Professional fleet management SaaS subscription for up to 25 vehicles. Full feature set, cancel anytime.',
				'cats'          => array( 'fleet-software' ),
				'sku'           => 'FM-SAAS-PRO-MO',
				'tags'          => array( 'SaaS', 'Fleet', 'Software', 'Subscription' ),
				'featured'      => true,
				'gps_fields'    => array(),
			),
			array(
				'name'          => 'Magnetic GPS Tracker Mini',
				'price'         => '89.99',
				'sale_price'    => '',
				'description'   => '<p>The Magnetic GPS Tracker Mini is a compact, discreet tracker with a powerful magnet for covert installation under any metal surface. Perfect for asset protection, equipment tracking and vehicle security.</p><ul><li>Powerful integrated magnet</li><li>IP66 waterproof housing</li><li>Long-life battery (up to 60 days)</li><li>Compact: 75 × 40 × 18mm</li><li>Ideal for trailers, tools and equipment</li></ul>',
				'short_desc'    => 'Compact magnetic GPS tracker with 60-day battery and IP66 waterproofing for covert vehicle and asset tracking.',
				'cats'          => array( 'gps-trackers' ),
				'sku'           => 'FM-MAG-MINI',
				'tags'          => array( 'GPS', 'Waterproof', 'Anti-theft', 'Magnetic' ),
				'featured'      => false,
				'gps_fields'    => array(
					'_gps_device_id'    => 'Magnetic Mini',
					'_gps_connectivity' => '4G',
					'_gps_accuracy'     => '< 3m CEP',
					'_gps_battery'      => '60 days tracking mode',
					'_gps_waterproof'   => 'IP67',
					'_gps_install_type' => 'Magnetic (no tools)',
				),
			),
			array(
				'name'          => 'GPS SIM Card – 1 Year Data',
				'price'         => '29.99',
				'sale_price'    => '',
				'description'   => '<p>Pre-activated multi-network SIM card optimised for GPS tracker data. Includes 1 year of data roaming across 180+ countries. No contracts – renew annually.</p><ul><li>Multi-network automatic roaming</li><li>180+ countries coverage</li><li>Optimised for GPS tracker protocols (MQTT, TCP)</li><li>100 MB/month included</li><li>Nano + Micro + Standard SIM adapters included</li></ul>',
				'short_desc'    => 'Pre-activated GPS SIM card with 1-year data plan, roaming in 180+ countries.',
				'cats'          => array( 'accessories' ),
				'sku'           => 'FM-SIM-1Y',
				'tags'          => array( 'SIM', 'Accessories', 'GPS' ),
				'featured'      => false,
				'gps_fields'    => array(),
			),
		);

		foreach ( $products as $product_data ) {
			$product = new WC_Product_Simple();

			$product->set_name( $product_data['name'] );
			$product->set_status( 'publish' );
			$product->set_description( $product_data['description'] );
			$product->set_short_description( $product_data['short_desc'] );
			$product->set_sku( $product_data['sku'] );
			$product->set_regular_price( $product_data['price'] );

			if ( ! empty( $product_data['sale_price'] ) ) {
				$product->set_sale_price( $product_data['sale_price'] );
			}

			$product->set_manage_stock( true );
			$product->set_stock_quantity( 100 );
			$product->set_stock_status( 'instock' );
			$product->set_sold_individually( false );
			$product->set_featured( $product_data['featured'] );

			// Categories
			$cat_ids = array();
			foreach ( $product_data['cats'] as $cat_slug ) {
				if ( ! empty( $cat_map[ $cat_slug ] ) ) {
					$cat_ids[] = $cat_map[ $cat_slug ];
				}
			}
			$product->set_category_ids( $cat_ids );

			// Tags
			if ( ! empty( $product_data['tags'] ) ) {
				$tag_ids = array();
				foreach ( $product_data['tags'] as $tag_name ) {
					$tag = get_term_by( 'name', $tag_name, 'product_tag' );
					if ( ! $tag ) {
						$result = wp_insert_term( $tag_name, 'product_tag' );
						if ( ! is_wp_error( $result ) ) {
							$tag_ids[] = $result['term_id'];
						}
					} else {
						$tag_ids[] = $tag->term_id;
					}
				}
				$product->set_tag_ids( $tag_ids );
			}

			$product_id = $product->save();

			// Save GPS-specific meta fields
			if ( $product_id && ! empty( $product_data['gps_fields'] ) ) {
				foreach ( $product_data['gps_fields'] as $meta_key => $meta_value ) {
					update_post_meta( $product_id, $meta_key, $meta_value );
				}
			}
		}
	}
}
