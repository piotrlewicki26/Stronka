<?php
/**
 * Generic page template
 *
 * @package FleetMonitor
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="page-hero">
	<div class="container">
		<h1 class="page-hero-title"><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p class="page-hero-subtitle"><?php the_excerpt(); ?></p>
		<?php endif; ?>
	</div>
</div>

<div class="page-content-wrap">
	<div class="container">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-article' ); ?>>
			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fleetmonitor' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
		</article>
	</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
