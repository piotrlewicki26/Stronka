<?php
/**
 * The sidebar template
 *
 * @package FleetLink
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside class="blog-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Blog sidebar', 'fleetlink' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
