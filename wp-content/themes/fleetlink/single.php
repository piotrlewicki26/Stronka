<?php
/**
 * Single post template
 *
 * @package FleetLink
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="page-hero">
	<div class="container">
		<nav class="breadcrumb-list" aria-label="<?php esc_attr_e( 'Breadcrumb', 'fleetlink' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'fleetlink' ); ?></a>
			&rsaquo;
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'fleetlink' ); ?></a>
			&rsaquo;
			<span><?php the_title(); ?></span>
		</nav>
		<h1 class="page-hero-title" style="max-width:800px; margin:1rem auto 0;"><?php the_title(); ?></h1>
		<div style="margin-top:1rem; color:rgba(255,255,255,.65); font-size:.875rem; display:flex; gap:1.5rem; justify-content:center; flex-wrap:wrap;">
			<span><?php echo esc_html( get_the_date() ); ?></span>
			<span><?php the_author(); ?></span>
			<?php $cats = get_the_category(); if ( $cats ) : ?>
				<span><?php echo esc_html( $cats[0]->name ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="page-content-wrap">
	<div class="container">
		<div class="page-content-inner">

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-article' ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<div style="margin-bottom: 2rem; border-radius: var(--radius-xl); overflow: hidden;">
						<?php the_post_thumbnail( 'fleetlink-card', array( 'style' => 'width:100%; height:auto;' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-content">
					<?php
					the_content(
						sprintf(
							wp_kses(
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'fleetlink' ),
								array( 'span' => array( 'class' => array() ) )
							),
							wp_kses_post( get_the_title() )
						)
					);

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fleetlink' ),
							'after'  => '</div>',
						)
					);
					?>
				</div><!-- .entry-content -->

				<!-- Post Tags -->
				<?php $tags = get_the_tags(); if ( $tags ) : ?>
					<div class="entry-tags" style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--color-gray-200);">
						<strong style="font-size:.875rem; color:var(--color-gray-600);"><?php esc_html_e( 'Tags:', 'fleetlink' ); ?></strong>
						<?php foreach ( $tags as $tag ) : ?>
							<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
							   style="display:inline-block; margin:0 .25rem; padding:.2rem .75rem; background:var(--color-gray-100); border-radius:var(--radius-full); font-size:.8rem; color:var(--color-gray-700); transition:all .2s;">
								<?php echo esc_html( $tag->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- Author Box -->
				<div class="author-box" style="margin-top:2rem; padding:1.5rem; background:var(--color-gray-100); border-radius:var(--radius-xl); display:flex; gap:1rem; align-items:center;">
					<div style="flex-shrink:0;">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 64, '', '', array( 'style' => 'border-radius:50%;' ) ); ?>
					</div>
					<div>
						<strong style="font-size:.9rem; color:var(--color-primary);"><?php the_author(); ?></strong>
						<p style="font-size:.85rem; color:var(--color-gray-600); margin-top:.25rem;">
							<?php the_author_meta( 'description' ); ?>
						</p>
					</div>
				</div>

				<!-- Navigation -->
				<nav class="post-navigation" style="margin-top:2rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;" aria-label="<?php esc_attr_e( 'Post navigation', 'fleetlink' ); ?>">
					<?php
					$prev = get_previous_post();
					$next = get_next_post();
					if ( $prev ) : ?>
						<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" style="display:block; padding:1rem; background:var(--color-white); border:1px solid var(--color-gray-200); border-radius:var(--radius-lg); text-decoration:none;">
							<span style="font-size:.75rem; color:var(--color-gray-500); text-transform:uppercase; letter-spacing:.05em;">&larr; <?php esc_html_e( 'Previous', 'fleetlink' ); ?></span>
							<p style="font-size:.9rem; font-weight:600; color:var(--color-primary); margin-top:.25rem;"><?php echo esc_html( get_the_title( $prev ) ); ?></p>
						</a>
					<?php endif; ?>
					<?php if ( $next ) : ?>
						<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" style="display:block; padding:1rem; background:var(--color-white); border:1px solid var(--color-gray-200); border-radius:var(--radius-lg); text-decoration:none; text-align:right; grid-column: <?php echo $prev ? 'auto' : '2'; ?>;">
							<span style="font-size:.75rem; color:var(--color-gray-500); text-transform:uppercase; letter-spacing:.05em;"><?php esc_html_e( 'Next', 'fleetlink' ); ?> &rarr;</span>
							<p style="font-size:.9rem; font-weight:600; color:var(--color-primary); margin-top:.25rem;"><?php echo esc_html( get_the_title( $next ) ); ?></p>
						</a>
					<?php endif; ?>
				</nav>

				<!-- Comments -->
				<?php if ( comments_open() || get_comments_number() ) : ?>
					<div style="margin-top:2rem;">
						<?php comments_template(); ?>
					</div>
				<?php endif; ?>

			</article>

		</div>
	</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
