<?php
/**
 * Single product template override
 *
 * @package FleetLink
 * @see https://docs.woocommerce.com/document/template-structure/
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

while ( have_posts() ) :
	the_post();
	global $product;
?>

<!-- Product Hero Area -->
<div class="single-product-hero">
	<div class="container">
		<!-- Breadcrumb -->
		<nav style="font-size:.875rem; color:rgba(0,0,0,.5); margin-bottom:2rem;" aria-label="<?php esc_attr_e( 'Breadcrumb', 'fleetlink' ); ?>">
			<?php woocommerce_breadcrumb(); ?>
		</nav>

		<div class="single-product-layout" id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

			<!-- Product Gallery -->
			<div class="product-gallery-area">
				<div class="product-gallery-main" id="product-gallery-main">
					<?php
					$image_id = $product->get_image_id();
					if ( $image_id ) {
						echo wp_get_attachment_image( $image_id, 'fleetlink-square', false, array( 'id' => 'product-main-image' ) );
					} else {
						echo '<div style="display:flex; align-items:center; justify-content:center; width:100%; height:100%;">';
						echo '<svg width="200" height="200" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">';
						echo '<rect x="30" y="30" width="140" height="140" rx="24" fill="#e8f3ff" stroke="#0e7afe" stroke-width="3"/>';
						echo '<rect x="55" y="55" width="90" height="60" rx="10" fill="#0e7afe" opacity=".15"/>';
						echo '<circle cx="100" cy="85" r="20" fill="#0e7afe" opacity=".3"/>';
						echo '<circle cx="100" cy="85" r="10" fill="#0e7afe"/>';
						echo '</svg>';
						echo '</div>';
					}
					?>
				</div>

				<?php
				$gallery_image_ids = $product->get_gallery_image_ids();
				if ( ! empty( $gallery_image_ids ) ) :
				?>
					<div class="product-gallery-thumbs">
						<?php
						// Show main image as first thumb
						if ( $image_id ) {
							printf(
								'<button class="product-thumb active" data-image-id="%d" aria-label="%s">%s</button>',
								esc_attr( $image_id ),
								esc_attr__( 'Main product image', 'fleetlink' ),
								wp_get_attachment_image( $image_id, 'thumbnail' )
							);
						}
						foreach ( $gallery_image_ids as $gid ) {
							printf(
								'<button class="product-thumb" data-image-id="%d" aria-label="%s">%s</button>',
								esc_attr( $gid ),
								esc_attr( get_post_meta( $gid, '_wp_attachment_image_alt', true ) ) ?: esc_attr__( 'Product gallery image', 'fleetlink' ),
								wp_get_attachment_image( $gid, 'thumbnail' )
							);
						}
						?>
					</div>
				<?php endif; ?>
			</div><!-- .product-gallery-area -->

			<!-- Product Summary -->
			<div class="product-summary-area">
				<?php
				// Category
				$categories = wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-category">', '</div>' );
				echo $categories; // phpcs:ignore WordPress.Security.EscapeOutput

				// Title
				echo '<h1 class="product-title">' . get_the_title() . '</h1>'; // phpcs:ignore WordPress.Security.EscapeOutput

				// Rating
				if ( wc_review_ratings_enabled() ) {
					woocommerce_template_single_rating();
				}

				// Price
				echo '<div class="product-price-display">' . $product->get_price_html() . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput

				// Short description
				if ( $product->get_short_description() ) {
					echo '<div class="product-short-description">' . wp_kses_post( $product->get_short_description() ) . '</div>';
				}

				// Add to cart
				woocommerce_template_single_add_to_cart();

				// Meta (SKU, categories)
				woocommerce_template_single_meta();

				// Share
				do_action( 'woocommerce_single_product_summary' );
				?>

				<!-- Trust signals -->
				<div style="margin-top:1.5rem; padding:1.5rem; background:var(--color-gray-100); border-radius:var(--radius-xl); display:grid; grid-template-columns:repeat(3,1fr); gap:1rem;">
					<?php
					$trust = array(
						array( 'icon' => '🚚', 'text' => __( 'Free shipping over €200', 'fleetlink' ) ),
						array( 'icon' => '🔒', 'text' => __( '2-year warranty', 'fleetlink' ) ),
						array( 'icon' => '↩️', 'text' => __( '30-day returns', 'fleetlink' ) ),
					);
					foreach ( $trust as $t ) :
					?>
					<div style="text-align:center;">
						<div style="font-size:1.5rem; margin-bottom:.25rem;"><?php echo esc_html( $t['icon'] ); ?></div>
						<div style="font-size:.75rem; color:var(--color-gray-600); font-weight:500;"><?php echo esc_html( $t['text'] ); ?></div>
					</div>
					<?php endforeach; ?>
				</div>

			</div><!-- .product-summary-area -->

		</div><!-- .single-product-layout -->
	</div><!-- .container -->
</div><!-- .single-product-hero -->

<!-- Product Details Tabs -->
<div style="background:white; padding:4rem 0; border-top:1px solid var(--color-gray-200);">
	<div class="container">
		<?php woocommerce_output_product_data_tabs(); ?>
	</div>
</div>

<!-- Related Products -->
<?php
$related_limit  = wc_get_loop_prop( 'columns' ) * 2;
$related_ids    = wc_get_related_products( $product->get_id(), $related_limit );
$related_args   = array(
	'post_type'      => 'product',
	'post__in'       => $related_ids,
	'posts_per_page' => 4,
);
$related_query  = new WP_Query( $related_args );

if ( $related_query->have_posts() ) :
?>
<section style="background:var(--color-gray-100); padding:4rem 0;">
	<div class="container">
		<h2 style="font-size:1.75rem; font-weight:800; color:var(--color-primary); margin-bottom:2rem;">
			<?php esc_html_e( 'Related Products', 'fleetlink' ); ?>
		</h2>
		<div class="shop-products woocommerce" style="grid-template-columns: repeat(4, 1fr);">
			<?php
			wc_set_loop_prop( 'name', 'related' );
			wc_set_loop_prop( 'columns', 4 );
			while ( $related_query->have_posts() ) {
				$related_query->the_post();
				wc_get_template_part( 'content', 'product' );
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer( 'shop' ); ?>
