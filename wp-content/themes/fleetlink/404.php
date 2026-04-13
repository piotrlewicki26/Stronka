<?php
/**
 * The 404 page template
 *
 * @package FleetLink
 */

get_header();
?>

<section style="min-height: calc(100vh - var(--header-height)); display:flex; align-items:center; background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%); padding: var(--space-20) 0;">
	<div class="container text-center" style="color:white;">
		<div style="font-size:8rem; font-weight:800; color:var(--color-accent); line-height:1; margin-bottom:1rem;" aria-hidden="true">404</div>
		<h1 style="font-size:2.5rem; font-weight:700; color:white; margin-bottom:1rem;">
			<?php esc_html_e( 'Vehicle not found in the fleet!', 'fleetlink' ); ?>
		</h1>
		<p style="font-size:1.125rem; color:rgba(255,255,255,.75); max-width:480px; margin:0 auto 2rem;">
			<?php esc_html_e( 'The page you\'re looking for seems to have taken an uncharted route. Let\'s get you back on track.', 'fleetlink' ); ?>
		</p>
		<div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; margin-bottom:2rem;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg">
				<?php esc_html_e( 'Back to Home', 'fleetlink' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-outline-white btn-lg">
				<?php esc_html_e( 'Contact Support', 'fleetlink' ); ?>
			</a>
		</div>

		<!-- Quick links -->
		<div style="display:flex; gap:2rem; justify-content:center; flex-wrap:wrap; margin-top:2rem;">
			<?php
			$quick_links = array(
				home_url( '/services/' )  => __( 'Our Services', 'fleetlink' ),
				home_url( '/shop/' )      => __( 'GPS Store', 'fleetlink' ),
				home_url( '/pricing/' )   => __( 'Pricing', 'fleetlink' ),
				home_url( '/blog/' )      => __( 'Blog', 'fleetlink' ),
			);
			foreach ( $quick_links as $url => $label ) {
				printf(
					'<a href="%s" style="color:rgba(255,255,255,.65); font-size:.875rem; text-decoration:underline; text-underline-offset:3px;">%s</a>',
					esc_url( $url ),
					esc_html( $label )
				);
			}
			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
