<?php
/**
 * Plugin Name:       FleetMonitor Core
 * Plugin URI:        https://fleetmonitor.pro
 * Description:       Core functionality for the FleetMonitor Pro WordPress theme. Adds vehicle tracking post types, fleet management features, WooCommerce product data, REST API endpoints and demo content installer.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            FleetMonitor Team
 * Author URI:        https://fleetmonitor.pro
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       fleetmonitor-core
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'FM_CORE_VERSION', '1.0.0' );
define( 'FM_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'FM_CORE_URI', plugin_dir_url( __FILE__ ) );
define( 'FM_CORE_BASENAME', plugin_basename( __FILE__ ) );

// =========================================================
// AUTOLOADER
// =========================================================

spl_autoload_register(
	function ( $class ) {
		$prefix = 'FleetMonitor\\';
		$base   = FM_CORE_DIR . 'includes/';

		if ( 0 !== strpos( $class, $prefix ) ) {
			return;
		}

		$relative = str_replace( '\\', DIRECTORY_SEPARATOR, substr( $class, strlen( $prefix ) ) );
		$file     = $base . 'class-' . strtolower( str_replace( '_', '-', $relative ) ) . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

// =========================================================
// LOAD PLUGIN FILES
// =========================================================

require_once FM_CORE_DIR . 'includes/class-vehicles.php';
require_once FM_CORE_DIR . 'includes/class-woocommerce.php';
require_once FM_CORE_DIR . 'includes/class-rest-api.php';
require_once FM_CORE_DIR . 'includes/class-demo-content.php';
require_once FM_CORE_DIR . 'admin/class-admin.php';

// =========================================================
// ACTIVATION / DEACTIVATION / UNINSTALL HOOKS
// =========================================================

register_activation_hook(
	__FILE__,
	array( 'FleetMonitor_Vehicles', 'on_activate' )
);

register_deactivation_hook(
	__FILE__,
	array( 'FleetMonitor_Vehicles', 'on_deactivate' )
);

// =========================================================
// BOOT
// =========================================================

add_action(
	'plugins_loaded',
	function () {
		load_plugin_textdomain( 'fleetmonitor-core', false, dirname( FM_CORE_BASENAME ) . '/languages' );

		// Boot classes
		FleetMonitor_Vehicles::init();
		FleetMonitor_WooCommerce::init();
		FleetMonitor_REST_API::init();

		if ( is_admin() ) {
			FleetMonitor_Admin::init();
		}
	}
);
