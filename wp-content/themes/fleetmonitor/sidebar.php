<?php
/**
 * The sidebar template
 *
 * @package FleetMonitor
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside class="blog-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Blog sidebar', 'fleetmonitor' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
