<?php
/**
 * Admin panel for FleetLink Core.
 *
 * @package FleetLink_Core
 */

defined( 'ABSPATH' ) || exit;

class FleetLink_Admin {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_assets' ) );
		add_action( 'admin_notices', array( __CLASS__, 'activation_notice' ) );
		add_filter( 'plugin_action_links_' . FM_CORE_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
		add_action( 'admin_init', array( __CLASS__, 'handle_demo_content' ) );
	}

	// ----------------------------------------------------------
	// ADMIN MENU
	// ----------------------------------------------------------

	public static function add_admin_menu() {
		add_menu_page(
			__( 'FleetLink', 'fleetmonitor-core' ),
			__( 'FleetLink', 'fleetmonitor-core' ),
			'manage_options',
			'fleetlink',
			array( __CLASS__, 'render_dashboard_page' ),
			'dashicons-location-alt',
			3
		);

		add_submenu_page(
			'fleetlink',
			__( 'Dashboard', 'fleetmonitor-core' ),
			__( 'Dashboard', 'fleetmonitor-core' ),
			'manage_options',
			'fleetlink',
			array( __CLASS__, 'render_dashboard_page' )
		);

		add_submenu_page(
			'fleetlink',
			__( 'Settings', 'fleetmonitor-core' ),
			__( 'Settings', 'fleetmonitor-core' ),
			'manage_options',
			'fleetmonitor-settings',
			array( __CLASS__, 'render_settings_page' )
		);

		add_submenu_page(
			'fleetlink',
			__( 'API Keys', 'fleetmonitor-core' ),
			__( 'API Keys', 'fleetmonitor-core' ),
			'manage_options',
			'fleetmonitor-api-keys',
			array( __CLASS__, 'render_api_keys_page' )
		);

		add_submenu_page(
			'fleetlink',
			__( 'Demo Content', 'fleetmonitor-core' ),
			__( 'Demo Content', 'fleetmonitor-core' ),
			'manage_options',
			'fleetmonitor-demo',
			array( __CLASS__, 'render_demo_page' )
		);
	}

	// ----------------------------------------------------------
	// ASSETS
	// ----------------------------------------------------------

	public static function enqueue_admin_assets( $hook ) {
		if ( strpos( $hook, 'fleetlink' ) === false ) {
			return;
		}

		wp_enqueue_style(
			'fm-admin-style',
			FM_CORE_URI . 'assets/css/admin.css',
			array(),
			FM_CORE_VERSION
		);
	}

	// ----------------------------------------------------------
	// ACTIVATION NOTICE
	// ----------------------------------------------------------

	public static function activation_notice() {
		if ( ! get_transient( 'fm_core_activated' ) ) {
			return;
		}
		delete_transient( 'fm_core_activated' );
		?>
		<div class="notice notice-success is-dismissible">
			<p>
				<?php
				printf(
					/* translators: %s: settings page link */
					esc_html__( 'FleetLink Core activated successfully! 🚀 Go to %s to configure the plugin.', 'fleetmonitor-core' ),
					'<a href="' . esc_url( admin_url( 'admin.php?page=fleetmonitor' ) ) . '">' . esc_html__( 'FleetLink Dashboard', 'fleetmonitor-core' ) . '</a>'
				);
				?>
			</p>
		</div>
		<?php
	}

	// ----------------------------------------------------------
	// PLUGIN ACTION LINKS
	// ----------------------------------------------------------

	public static function plugin_action_links( $links ) {
		$action_links = array(
			'<a href="' . esc_url( admin_url( 'admin.php?page=fleetmonitor-settings' ) ) . '">' . esc_html__( 'Settings', 'fleetmonitor-core' ) . '</a>',
			'<a href="' . esc_url( admin_url( 'admin.php?page=fleetmonitor' ) ) . '">' . esc_html__( 'Dashboard', 'fleetmonitor-core' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	// ----------------------------------------------------------
	// DASHBOARD PAGE
	// ----------------------------------------------------------

	public static function render_dashboard_page() {
		$vehicle_count    = wp_count_posts( 'fm_vehicle' )->publish ?? 0;
		$fleet_count      = wp_count_posts( 'fm_fleet' )->publish ?? 0;
		$testimonial_count = wp_count_posts( 'fm_testimonial' )->publish ?? 0;
		$product_count    = class_exists( 'WooCommerce' ) ? ( wp_count_posts( 'product' )->publish ?? 0 ) : 0;
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'FleetLink Dashboard', 'fleetmonitor-core' ); ?></h1>
			<p><?php esc_html_e( 'Welcome to FleetLink Core — your vehicle monitoring and fleet management WordPress plugin.', 'fleetmonitor-core' ); ?></p>

			<!-- Stats Cards -->
			<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin:24px 0;">
				<?php
				$cards = array(
					array(
						'label' => __( 'Vehicles', 'fleetmonitor-core' ),
						'value' => $vehicle_count,
						'link'  => admin_url( 'edit.php?post_type=fm_vehicle' ),
						'color' => '#0e7afe',
						'icon'  => '🚗',
					),
					array(
						'label' => __( 'Fleets', 'fleetmonitor-core' ),
						'value' => $fleet_count,
						'link'  => admin_url( 'edit.php?post_type=fm_fleet' ),
						'color' => '#28a745',
						'icon'  => '🏭',
					),
					array(
						'label' => __( 'Products', 'fleetmonitor-core' ),
						'value' => $product_count,
						'link'  => admin_url( 'edit.php?post_type=product' ),
						'color' => '#f76b1c',
						'icon'  => '📦',
					),
					array(
						'label' => __( 'Testimonials', 'fleetmonitor-core' ),
						'value' => $testimonial_count,
						'link'  => admin_url( 'edit.php?post_type=fm_testimonial' ),
						'color' => '#6f42c1',
						'icon'  => '⭐',
					),
				);
				foreach ( $cards as $card ) :
				?>
				<div style="background:#fff; border:1px solid #e2e8f0; border-top:3px solid <?php echo esc_attr( $card['color'] ); ?>; border-radius:8px; padding:20px; text-align:center;">
					<div style="font-size:2rem; margin-bottom:.5rem;"><?php echo esc_html( $card['icon'] ); ?></div>
					<div style="font-size:2.5rem; font-weight:800; color:<?php echo esc_attr( $card['color'] ); ?>;"><?php echo esc_html( $card['value'] ); ?></div>
					<div style="font-size:.875rem; color:#6c757d; margin-top:.25rem;"><?php echo esc_html( $card['label'] ); ?></div>
					<a href="<?php echo esc_url( $card['link'] ); ?>" style="font-size:.8rem; color:<?php echo esc_attr( $card['color'] ); ?>; display:block; margin-top:.5rem;"><?php esc_html_e( 'Manage →', 'fleetmonitor-core' ); ?></a>
				</div>
				<?php endforeach; ?>
			</div>

			<!-- Quick Actions -->
			<h2><?php esc_html_e( 'Quick Actions', 'fleetmonitor-core' ); ?></h2>
			<div style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=fm_vehicle' ) ); ?>" class="button button-primary"><?php esc_html_e( '+ Add Vehicle', 'fleetmonitor-core' ); ?></a>
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=fm_fleet' ) ); ?>" class="button"><?php esc_html_e( '+ Add Fleet', 'fleetmonitor-core' ); ?></a>
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=fm_testimonial' ) ); ?>" class="button"><?php esc_html_e( '+ Add Testimonial', 'fleetmonitor-core' ); ?></a>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=product' ) ); ?>" class="button"><?php esc_html_e( '+ Add Product', 'fleetmonitor-core' ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=fleetmonitor-demo' ) ); ?>" class="button button-secondary"><?php esc_html_e( 'Demo Content', 'fleetmonitor-core' ); ?></a>
				<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button"><?php esc_html_e( 'Customise Theme', 'fleetmonitor-core' ); ?></a>
			</div>

			<!-- System Info -->
			<h2><?php esc_html_e( 'System Information', 'fleetmonitor-core' ); ?></h2>
			<table class="widefat" style="max-width:600px;">
				<tbody>
					<tr><th><?php esc_html_e( 'Plugin Version', 'fleetmonitor-core' ); ?></th><td><?php echo esc_html( FM_CORE_VERSION ); ?></td></tr>
					<tr><th><?php esc_html_e( 'WordPress Version', 'fleetmonitor-core' ); ?></th><td><?php echo esc_html( get_bloginfo( 'version' ) ); ?></td></tr>
					<tr><th><?php esc_html_e( 'WooCommerce Version', 'fleetmonitor-core' ); ?></th><td><?php echo defined( 'WC_VERSION' ) ? esc_html( WC_VERSION ) : '<span style="color:#dc3545;">' . esc_html__( 'Not installed', 'fleetmonitor-core' ) . '</span>'; ?></td></tr>
					<tr><th><?php esc_html_e( 'PHP Version', 'fleetmonitor-core' ); ?></th><td><?php echo esc_html( PHP_VERSION ); ?></td></tr>
					<tr><th><?php esc_html_e( 'Active Theme', 'fleetmonitor-core' ); ?></th><td><?php echo esc_html( wp_get_theme()->get( 'Name' ) ); ?></td></tr>
					<tr><th><?php esc_html_e( 'REST API Base', 'fleetmonitor-core' ); ?></th><td><code><?php echo esc_html( rest_url( 'fleetmonitor/v1' ) ); ?></code></td></tr>
				</tbody>
			</table>
		</div>
		<?php
	}

	// ----------------------------------------------------------
	// SETTINGS PAGE
	// ----------------------------------------------------------

	public static function render_settings_page() {
		if ( isset( $_POST['fm_save_settings'] ) ) {
			check_admin_referer( 'fm_settings_save' );
			update_option( 'fm_google_maps_key', sanitize_text_field( wp_unslash( $_POST['fm_google_maps_key'] ?? '' ) ) );
			update_option( 'fm_live_update_interval', (int) ( $_POST['fm_live_update_interval'] ?? 30 ) );
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Settings saved.', 'fleetmonitor-core' ) . '</p></div>';
		}

		$gmap_key = get_option( 'fm_google_maps_key', '' );
		$interval = get_option( 'fm_live_update_interval', 30 );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'FleetLink Settings', 'fleetmonitor-core' ); ?></h1>
			<form method="post">
				<?php wp_nonce_field( 'fm_settings_save' ); ?>
				<table class="form-table">
					<tr>
						<th><label for="fm_google_maps_key"><?php esc_html_e( 'Google Maps API Key', 'fleetmonitor-core' ); ?></label></th>
						<td>
							<input type="text" id="fm_google_maps_key" name="fm_google_maps_key" value="<?php echo esc_attr( $gmap_key ); ?>" class="regular-text" placeholder="AIzaSy...">
							<p class="description"><?php esc_html_e( 'Required for the live map feature.', 'fleetmonitor-core' ); ?></p>
						</td>
					</tr>
					<tr>
						<th><label for="fm_live_update_interval"><?php esc_html_e( 'Live Map Update Interval (seconds)', 'fleetmonitor-core' ); ?></label></th>
						<td>
							<input type="number" id="fm_live_update_interval" name="fm_live_update_interval" value="<?php echo esc_attr( $interval ); ?>" min="5" max="300" class="small-text">
							<p class="description"><?php esc_html_e( 'How often (seconds) the live map polls for position updates. Minimum 5s.', 'fleetmonitor-core' ); ?></p>
						</td>
					</tr>
				</table>
				<p><input type="submit" name="fm_save_settings" class="button button-primary" value="<?php esc_attr_e( 'Save Settings', 'fleetmonitor-core' ); ?>"></p>
			</form>
		</div>
		<?php
	}

	// ----------------------------------------------------------
	// API KEYS PAGE
	// ----------------------------------------------------------

	public static function render_api_keys_page() {
		if ( isset( $_POST['fm_generate_key'] ) ) {
			check_admin_referer( 'fm_api_key_generate' );
			$new_key  = wp_generate_password( 40, false );
			$keys     = get_option( 'fm_api_keys', array() );
			$keys[]   = array(
				'label'     => sanitize_text_field( wp_unslash( $_POST['fm_key_label'] ?? '' ) ),
				'hash'      => hash( 'sha256', $new_key ),
				'created'   => gmdate( 'Y-m-d H:i:s' ),
				'last_used' => null,
			);
			update_option( 'fm_api_keys', $keys );
			echo '<div class="notice notice-success"><p>' . sprintf( esc_html__( 'New API key generated: %s — Save this, it will not be shown again.', 'fleetmonitor-core' ), '<code style="background:#f0f0f0; padding:4px 8px;">' . esc_html( $new_key ) . '</code>' ) . '</p></div>';
		}

		if ( isset( $_POST['fm_delete_key'] ) ) {
			check_admin_referer( 'fm_api_key_delete' );
			$idx  = (int) ( $_POST['fm_key_index'] ?? -1 );
			$keys = get_option( 'fm_api_keys', array() );
			if ( isset( $keys[ $idx ] ) ) {
				array_splice( $keys, $idx, 1 );
				update_option( 'fm_api_keys', $keys );
			}
		}

		$keys = get_option( 'fm_api_keys', array() );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'API Keys', 'fleetmonitor-core' ); ?></h1>
			<p><?php esc_html_e( 'API keys allow external applications (GPS devices, mobile apps) to authenticate with the FleetLink REST API.', 'fleetmonitor-core' ); ?></p>

			<form method="post" style="background:#fff; border:1px solid #ccd0d4; border-radius:4px; padding:16px; margin-bottom:24px; max-width:500px;">
				<?php wp_nonce_field( 'fm_api_key_generate' ); ?>
				<h3 style="margin-top:0;"><?php esc_html_e( 'Generate New API Key', 'fleetmonitor-core' ); ?></h3>
				<input type="text" name="fm_key_label" placeholder="<?php esc_attr_e( 'Key label (e.g. Mobile App)', 'fleetmonitor-core' ); ?>" class="regular-text" required>
				<p><input type="submit" name="fm_generate_key" class="button button-primary" value="<?php esc_attr_e( 'Generate Key', 'fleetmonitor-core' ); ?>"></p>
			</form>

			<?php if ( $keys ) : ?>
			<table class="widefat" style="max-width:700px;">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Label', 'fleetmonitor-core' ); ?></th>
						<th><?php esc_html_e( 'Created', 'fleetmonitor-core' ); ?></th>
						<th><?php esc_html_e( 'Actions', 'fleetmonitor-core' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $keys as $i => $key ) : ?>
					<tr>
						<td><?php echo esc_html( $key['label'] ); ?></td>
						<td><?php echo esc_html( $key['created'] ); ?></td>
						<td>
							<form method="post" style="display:inline;" onsubmit="return confirm('<?php esc_attr_e( 'Delete this key?', 'fleetmonitor-core' ); ?>');">
								<?php wp_nonce_field( 'fm_api_key_delete' ); ?>
								<input type="hidden" name="fm_key_index" value="<?php echo esc_attr( $i ); ?>">
								<input type="submit" name="fm_delete_key" class="button button-link-delete" value="<?php esc_attr_e( 'Delete', 'fleetmonitor-core' ); ?>">
							</form>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php else : ?>
			<p><?php esc_html_e( 'No API keys yet.', 'fleetmonitor-core' ); ?></p>
			<?php endif; ?>
		</div>
		<?php
	}

	// ----------------------------------------------------------
	// DEMO CONTENT PAGE
	// ----------------------------------------------------------

	public static function render_demo_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Demo Content', 'fleetmonitor-core' ); ?></h1>
			<p><?php esc_html_e( 'Install sample data to see how FleetLink looks with real content.', 'fleetmonitor-core' ); ?></p>

			<div style="background:#fff; border:1px solid #ccd0d4; border-radius:4px; padding:24px; max-width:600px;">
				<h2 style="margin-top:0;"><?php esc_html_e( 'What will be installed:', 'fleetmonitor-core' ); ?></h2>
				<ul style="list-style:disc; padding-left:1.5rem; color:#444; line-height:1.8;">
					<li><?php esc_html_e( '6 sample GPS/fleet products in the WooCommerce store', 'fleetmonitor-core' ); ?></li>
					<li><?php esc_html_e( '5 WooCommerce product categories (GPS Trackers, OBD, Dashcams, etc.)', 'fleetmonitor-core' ); ?></li>
					<li><?php esc_html_e( '5 sample vehicles with GPS metadata', 'fleetmonitor-core' ); ?></li>
					<li><?php esc_html_e( '3 sample testimonials from fleet managers', 'fleetmonitor-core' ); ?></li>
					<li><?php esc_html_e( '3 sample blog posts about fleet management', 'fleetmonitor-core' ); ?></li>
				</ul>
				<form method="post">
					<?php wp_nonce_field( 'fm_install_demo' ); ?>
					<p>
						<input type="submit" name="fm_install_demo" class="button button-primary button-large"
						       value="<?php esc_attr_e( 'Install Demo Content', 'fleetmonitor-core' ); ?>"
						       onclick="return confirm('<?php esc_attr_e( 'Install demo content? Existing products/testimonials/posts may not be duplicated.', 'fleetmonitor-core' ); ?>');">
					</p>
				</form>
			</div>
		</div>
		<?php
	}

	public static function handle_demo_content() {
		if (
			! isset( $_POST['fm_install_demo'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ?? '' ) ), 'fm_install_demo' ) ||
			! current_user_can( 'manage_options' )
		) {
			return;
		}

		require_once FM_CORE_DIR . 'includes/class-demo-content.php';
		FleetLink_Demo_Content::install();

		add_action(
			'admin_notices',
			function () {
				echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Demo content installed successfully!', 'fleetmonitor-core' ) . '</p></div>';
			}
		);
	}
}
