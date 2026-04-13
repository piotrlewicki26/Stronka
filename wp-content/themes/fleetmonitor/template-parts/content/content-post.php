<?php
/**
 * Template part: blog post card
 *
 * @package FleetMonitor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card' ); ?> role="listitem">
	<div class="blog-image">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
				<?php the_post_thumbnail( 'fleetmonitor-card' ); ?>
			</a>
		<?php endif; ?>
		<span class="blog-category-tag">
			<?php
			$cats = get_the_category();
			if ( $cats ) {
				echo esc_html( $cats[0]->name );
			} else {
				esc_html_e( 'Fleet Tips', 'fleetmonitor' );
			}
			?>
		</span>
	</div>

	<div class="blog-content">
		<div class="blog-meta">
			<span class="blog-date">
				<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
			</span>
			<span class="blog-read-time">
				<?php
				$word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
				$read_time  = max( 1, ceil( $word_count / 200 ) );
				printf( esc_html__( '%d min read', 'fleetmonitor' ), $read_time );
				?>
			</span>
		</div>

		<?php if ( is_singular() ) : ?>
			<h1 class="blog-title"><?php the_title(); ?></h1>
		<?php else : ?>
			<h2 class="blog-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
		<?php endif; ?>

		<p class="blog-excerpt"><?php the_excerpt(); ?></p>

		<a href="<?php the_permalink(); ?>" class="blog-link" aria-label="<?php printf( esc_attr__( 'Read more about %s', 'fleetmonitor' ), esc_html( get_the_title() ) ); ?>">
			<?php esc_html_e( 'Read more', 'fleetmonitor' ); ?>
			<?php echo fleetmonitor_icon( 'arrow-right' ); // phpcs:ignore ?>
		</a>
	</div>
</article>
