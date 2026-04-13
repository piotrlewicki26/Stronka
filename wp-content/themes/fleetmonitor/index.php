<?php
/**
 * The main template file (fallback for all archives and index)
 *
 * @package FleetMonitor
 */

get_header();
?>

<div class="page-hero">
	<div class="container">
		<?php
		if ( is_home() ) {
			echo '<h1 class="page-hero-title">' . esc_html__( 'Fleet Management Blog', 'fleetmonitor' ) . '</h1>';
			echo '<p class="page-hero-subtitle">' . esc_html__( 'Tips, guides and industry news on GPS tracking, fleet management and vehicle telematics.', 'fleetmonitor' ) . '</p>';
		} elseif ( is_category() ) {
			echo '<h1 class="page-hero-title">' . single_cat_title( '', false ) . '</h1>';
		} elseif ( is_tag() ) {
			echo '<h1 class="page-hero-title">' . single_tag_title( '', false ) . '</h1>';
		} elseif ( is_archive() ) {
			echo '<h1 class="page-hero-title">' . get_the_archive_title() . '</h1>';
		} elseif ( is_search() ) {
			printf( '<h1 class="page-hero-title">' . esc_html__( 'Search Results for: %s', 'fleetmonitor' ) . '</h1>', '<em>' . esc_html( get_search_query() ) . '</em>' );
		}
		?>
	</div>
</div>

<div class="page-content-wrap" style="background: var(--color-gray-100);">
	<div class="container">
		<div class="page-content-inner">

			<div class="blog-main">
				<?php if ( have_posts() ) : ?>

					<div class="blog-grid" role="list">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/content', 'post' ); ?>
						<?php endwhile; ?>
					</div>

					<?php the_posts_pagination(
						array(
							'prev_text'          => esc_html__( '&laquo; Previous', 'fleetmonitor' ),
							'next_text'          => esc_html__( 'Next &raquo;', 'fleetmonitor' ),
							'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page', 'fleetmonitor' ) . '</span>',
						)
					); ?>

				<?php else : ?>
					<div class="card card-body text-center" style="padding: 4rem 2rem;">
						<h2><?php esc_html_e( 'Nothing found', 'fleetmonitor' ); ?></h2>
						<p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Try a different search or browse our categories.', 'fleetmonitor' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				<?php endif; ?>
			</div><!-- .blog-main -->

			<?php get_sidebar(); ?>

		</div>
	</div>
</div>

<?php
get_footer();
