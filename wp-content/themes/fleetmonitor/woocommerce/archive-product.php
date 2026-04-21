<?php
/**
 * WooCommerce shop/archive template override
 *
 * @package FleetMonitor
 * @see https://docs.woocommerce.com/document/template-structure/
 * @version 3.3.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Shop hero
?>
<div class="woocommerce-shop-header">
	<div class="container">
		<?php woocommerce_breadcrumb(); ?>
		<?php if ( is_shop() ) : ?>
			<h1><?php esc_html_e( 'GPS Tracking & Fleet Hardware Store', 'fleetmonitor' ); ?></h1>
			<p style="margin-top:.5rem; font-size:1rem; color:rgba(255,255,255,.75); max-width:500px;">
				<?php esc_html_e( 'Professional GPS trackers, OBD devices, dashcams and fleet management software subscriptions.', 'fleetmonitor' ); ?>
			</p>
		<?php else : ?>
			<h1><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>
	</div>
</div>

<div class="shop-content">
	<div class="container">
		<div class="shop-layout">

			<!-- Sidebar Filters -->
			<aside class="shop-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Shop filters', 'fleetmonitor' ); ?>">

				<!-- Search within shop -->
				<div class="filter-section">
					<h3 class="filter-title"><?php esc_html_e( 'Search Products', 'fleetmonitor' ); ?></h3>
					<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div style="position:relative;">
							<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search…', 'fleetmonitor' ); ?>"
							       value="<?php echo esc_attr( get_search_query() ); ?>"
							       style="width:100%; padding:.6rem 2.5rem .6rem 1rem; border:1px solid var(--color-gray-300); border-radius:var(--radius-lg); font-size:.875rem;">
							<input type="hidden" name="post_type" value="product">
							<button type="submit" style="position:absolute; right:.5rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--color-gray-500);">
								<?php echo fleetmonitor_icon( 'search' ); // phpcs:ignore ?>
							</button>
						</div>
					</form>
				</div>

				<!-- Product Categories -->
				<div class="filter-section">
					<h3 class="filter-title"><?php esc_html_e( 'Categories', 'fleetmonitor' ); ?></h3>
					<ul style="display:flex; flex-direction:column; gap:.25rem;">
						<?php
						$product_cats = get_terms(
							array(
								'taxonomy'   => 'product_cat',
								'hide_empty' => true,
								'orderby'    => 'count',
								'order'      => 'DESC',
								'number'     => 10,
							)
						);

						if ( ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ) {
							foreach ( $product_cats as $cat ) {
								$active = ( is_product_category( $cat->slug ) ) ? ' style="color:var(--color-accent); font-weight:600;"' : '';
								printf(
									'<li><a href="%s"%s style="display:flex; justify-content:space-between; padding:.35rem 0; font-size:.875rem; color:var(--color-gray-700);">
										<span>%s</span>
										<span style="color:var(--color-gray-400); font-size:.8rem;">(%d)</span>
									</a></li>',
									esc_url( get_term_link( $cat ) ),
									$active,
									esc_html( $cat->name ),
									(int) $cat->count
								);
							}
						} else {
							// Default categories before products are added
							$defaults = array(
								__( 'GPS Trackers', 'fleetmonitor' ),
								__( 'OBD Devices', 'fleetmonitor' ),
								__( 'Dashcams', 'fleetmonitor' ),
								__( 'Fleet Software', 'fleetmonitor' ),
								__( 'Accessories', 'fleetmonitor' ),
							);
							foreach ( $defaults as $cat_name ) {
								printf(
									'<li style="padding:.35rem 0; font-size:.875rem; color:var(--color-gray-500);">%s</li>',
									esc_html( $cat_name )
								);
							}
						}
						?>
					</ul>
				</div>

				<!-- Price Range -->
				<div class="filter-section">
					<h3 class="filter-title"><?php esc_html_e( 'Price Range', 'fleetmonitor' ); ?></h3>
					<?php
					// WooCommerce price filter widget
					if ( is_active_sidebar( 'sidebar-shop' ) ) {
						dynamic_sidebar( 'sidebar-shop' );
					} else {
						// Manual price range filter fallback
						$min_price = isset( $_GET['min_price'] ) ? (float) $_GET['min_price'] : 0; // phpcs:ignore WordPress.Security.NonceVerification
						$max_price = isset( $_GET['max_price'] ) ? (float) $_GET['max_price'] : 1000; // phpcs:ignore WordPress.Security.NonceVerification
						?>
						<form method="get" action="<?php echo esc_url( wc_get_shop_url() ); ?>">
							<div class="price-range-inputs">
								<input type="number" name="min_price" class="price-input"
								       placeholder="<?php esc_attr_e( 'Min €', 'fleetmonitor' ); ?>"
								       value="<?php echo esc_attr( $min_price > 0 ? $min_price : '' ); ?>" min="0">
								<input type="number" name="max_price" class="price-input"
								       placeholder="<?php esc_attr_e( 'Max €', 'fleetmonitor' ); ?>"
								       value="<?php echo esc_attr( $max_price < 1000 ? $max_price : '' ); ?>" min="0">
							</div>
							<?php
							// Preserve existing query args
							foreach ( $_GET as $key => $val ) { // phpcs:ignore WordPress.Security.NonceVerification
								if ( ! in_array( $key, array( 'min_price', 'max_price' ), true ) ) {
									echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( wp_unslash( $val ) ) . '">';
								}
							}
							?>
							<button type="submit" class="btn btn-primary btn-sm" style="margin-top:.75rem; width:100%;">
								<?php esc_html_e( 'Apply Filter', 'fleetmonitor' ); ?>
							</button>
						</form>
					<?php } ?>
				</div>

				<!-- Product Tags -->
				<div class="filter-section">
					<h3 class="filter-title"><?php esc_html_e( 'Tags', 'fleetmonitor' ); ?></h3>
					<div style="display:flex; flex-wrap:wrap; gap:.35rem;">
						<?php
						$product_tags = get_terms(
							array(
								'taxonomy'   => 'product_tag',
								'hide_empty' => true,
								'number'     => 15,
							)
						);

						if ( ! empty( $product_tags ) && ! is_wp_error( $product_tags ) ) {
							foreach ( $product_tags as $tag ) {
								printf(
									'<a href="%s" style="display:inline-block; padding:.2rem .6rem; background:var(--color-gray-100); border-radius:var(--radius-full); font-size:.75rem; color:var(--color-gray-700); transition:all .2s;">%s</a>',
									esc_url( get_term_link( $tag ) ),
									esc_html( $tag->name )
								);
							}
						} else {
							$default_tags = array( 'GPS', '4G', 'OBD', '4K', 'Waterproof', 'Real-time', 'Fleet', 'Anti-theft' );
							foreach ( $default_tags as $tag_name ) {
								echo '<span style="display:inline-block; padding:.2rem .6rem; background:var(--color-gray-100); border-radius:var(--radius-full); font-size:.75rem; color:var(--color-gray-500);">' . esc_html( $tag_name ) . '</span>';
							}
						}
						?>
					</div>
				</div>

			</aside><!-- .shop-sidebar -->

			<!-- Main Products Area -->
			<div class="shop-main-area">

				<?php woocommerce_output_all_notices(); ?>

				<?php if ( woocommerce_product_loop() ) : ?>

					<!-- Toolbar -->
					<div class="shop-toolbar">
						<div class="result-count">
							<?php woocommerce_result_count(); ?>
						</div>
						<div class="shop-toolbar-right">
							<?php woocommerce_catalog_ordering(); ?>

							<div class="view-toggles" role="group" aria-label="<?php esc_attr_e( 'View', 'fleetmonitor' ); ?>">
								<button class="view-toggle-btn active" data-view="grid" aria-label="<?php esc_attr_e( 'Grid view', 'fleetmonitor' ); ?>" aria-pressed="true">
									<?php echo fleetmonitor_icon( 'grid' ); // phpcs:ignore ?>
								</button>
								<button class="view-toggle-btn" data-view="list" aria-label="<?php esc_attr_e( 'List view', 'fleetmonitor' ); ?>" aria-pressed="false">
									<?php echo fleetmonitor_icon( 'list' ); // phpcs:ignore ?>
								</button>
							</div>
						</div>
					</div>

					<!-- Products Loop -->
					<div class="shop-products woocommerce" id="shop-products-grid">
						<?php
						woocommerce_product_loop_start();

						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();
								do_action( 'woocommerce_shop_loop' );
								wc_get_template_part( 'content', 'product' );
							}
						}

						woocommerce_product_loop_end();
						?>
					</div>

					<?php woocommerce_after_shop_loop(); ?>

				<?php else : ?>
					<?php do_action( 'woocommerce_no_products_found' ); ?>
				<?php endif; ?>

			</div><!-- .shop-main-area -->

		</div><!-- .shop-layout -->
	</div><!-- .container -->
</div><!-- .shop-content -->

<?php get_footer( 'shop' ); ?>
