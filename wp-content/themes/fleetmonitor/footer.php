</main><!-- #main-content -->

<!-- =====================================================
     SITE FOOTER
     ===================================================== -->
<footer class="site-footer" id="site-footer" role="contentinfo">

	<div class="footer-main">
		<div class="container">
			<div class="footer-grid">

				<!-- Brand Column -->
				<div class="footer-brand">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						<div class="logo-icon" aria-hidden="true">
							<?php echo fleetmonitor_icon( 'location-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						</div>
						<div class="logo-text">
							<span class="logo-name"><?php bloginfo( 'name' ); ?></span>
							<span class="logo-tagline"><?php esc_html_e( 'Fleet &amp; GPS Management', 'fleetmonitor' ); ?></span>
						</div>
					</a>

					<p class="footer-description">
						<?php esc_html_e( 'Professional GPS vehicle monitoring and fleet management platform. Real-time tracking, driver analytics and a complete store for GPS hardware.', 'fleetmonitor' ); ?>
					</p>

					<!-- Contact info -->
					<div class="footer-contact-info" style="margin-bottom: 1.5rem;">
						<div class="footer-contact-item">
							<span class="footer-contact-icon" aria-hidden="true">
								<?php echo fleetmonitor_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							</span>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', get_theme_mod( 'company_phone', '+48221234567' ) ) ); ?>" style="color: rgba(255,255,255,.65);">
								<?php echo esc_html( get_theme_mod( 'company_phone', '+48 22 123 456 789' ) ); ?>
							</a>
						</div>
						<div class="footer-contact-item">
							<span class="footer-contact-icon" aria-hidden="true">
								<?php echo fleetmonitor_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							</span>
							<a href="mailto:<?php echo esc_attr( get_theme_mod( 'company_email', 'contact@fleetmonitor.pro' ) ); ?>" style="color: rgba(255,255,255,.65);">
								<?php echo esc_html( get_theme_mod( 'company_email', 'contact@fleetmonitor.pro' ) ); ?>
							</a>
						</div>
						<div class="footer-contact-item">
							<span class="footer-contact-icon" aria-hidden="true">
								<?php echo fleetmonitor_icon( 'address' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							</span>
							<span><?php echo esc_html( get_theme_mod( 'company_address', 'ul. Technologiczna 15, 00-001 Warszawa, Poland' ) ); ?></span>
						</div>
					</div>

					<!-- Social Links -->
					<div class="footer-social" role="list" aria-label="<?php esc_attr_e( 'Social media links', 'fleetmonitor' ); ?>">
						<?php
						$social_links = array(
							'facebook'  => array( 'icon' => 'fb', 'label' => 'Facebook' ),
							'twitter'   => array( 'icon' => 'tw', 'label' => 'Twitter / X' ),
							'linkedin'  => array( 'icon' => 'li', 'label' => 'LinkedIn' ),
							'youtube'   => array( 'icon' => 'yt', 'label' => 'YouTube' ),
							'instagram' => array( 'icon' => 'ig', 'label' => 'Instagram' ),
						);
						foreach ( $social_links as $key => $data ) {
							$url = get_theme_mod( "social_{$key}", '' );
							if ( $url ) {
								printf(
									'<a href="%s" class="social-link" target="_blank" rel="noopener noreferrer" role="listitem" aria-label="%s">%s</a>',
									esc_url( $url ),
									esc_attr( $data['label'] ),
									fleetmonitor_icon( $data['icon'] ) // phpcs:ignore WordPress.Security.EscapeOutput
								);
							}
						}
						// Default fallback social links if none set
						if ( ! get_theme_mod( 'social_facebook' ) ) :
						?>
						<a href="#" class="social-link" aria-label="Facebook"><?php echo fleetmonitor_icon( 'fb' ); // phpcs:ignore ?></a>
						<a href="#" class="social-link" aria-label="Twitter"><?php echo fleetmonitor_icon( 'tw' ); // phpcs:ignore ?></a>
						<a href="#" class="social-link" aria-label="LinkedIn"><?php echo fleetmonitor_icon( 'li' ); // phpcs:ignore ?></a>
						<a href="#" class="social-link" aria-label="YouTube"><?php echo fleetmonitor_icon( 'yt' ); // phpcs:ignore ?></a>
						<?php endif; ?>
					</div>
				</div><!-- .footer-brand -->

				<!-- Products Column -->
				<div class="footer-nav-col">
					<h4 class="footer-col-title"><?php esc_html_e( 'Products', 'fleetmonitor' ); ?></h4>
					<?php
					if ( has_nav_menu( 'footer-1' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer-1',
								'container'      => false,
								'menu_class'     => 'footer-links',
								'depth'          => 1,
							)
						);
					} else {
						echo '<ul class="footer-links">';
						$links = array(
							home_url( '/shop/gps-trackers/' )              => __( 'GPS Trackers', 'fleetmonitor' ),
							home_url( '/shop/fleet-management-software/' ) => __( 'Fleet Software', 'fleetmonitor' ),
							home_url( '/shop/obd-devices/' )               => __( 'OBD Devices', 'fleetmonitor' ),
							home_url( '/shop/dashcams/' )                  => __( 'Dashcams', 'fleetmonitor' ),
							home_url( '/shop/accessories/' )               => __( 'Accessories', 'fleetmonitor' ),
							home_url( '/pricing/' )                        => __( 'Pricing Plans', 'fleetmonitor' ),
						);
						foreach ( $links as $url => $label ) {
							printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
						}
						echo '</ul>';
					}
					?>
				</div>

				<!-- Company Column -->
				<div class="footer-nav-col">
					<h4 class="footer-col-title"><?php esc_html_e( 'Company', 'fleetmonitor' ); ?></h4>
					<?php
					if ( has_nav_menu( 'footer-2' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer-2',
								'container'      => false,
								'menu_class'     => 'footer-links',
								'depth'          => 1,
							)
						);
					} else {
						echo '<ul class="footer-links">';
						$links = array(
							home_url( '/about/' )    => __( 'About Us', 'fleetmonitor' ),
							home_url( '/services/' ) => __( 'Services', 'fleetmonitor' ),
							home_url( '/blog/' )     => __( 'Blog', 'fleetmonitor' ),
							home_url( '/careers/' )  => __( 'Careers', 'fleetmonitor' ),
							home_url( '/partners/' ) => __( 'Partners', 'fleetmonitor' ),
							home_url( '/press/' )    => __( 'Press', 'fleetmonitor' ),
						);
						foreach ( $links as $url => $label ) {
							printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
						}
						echo '</ul>';
					}
					?>
				</div>

				<!-- Support Column -->
				<div class="footer-nav-col">
					<h4 class="footer-col-title"><?php esc_html_e( 'Support', 'fleetmonitor' ); ?></h4>
					<?php
					if ( has_nav_menu( 'footer-3' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer-3',
								'container'      => false,
								'menu_class'     => 'footer-links',
								'depth'          => 1,
							)
						);
					} else {
						echo '<ul class="footer-links">';
						$links = array(
							home_url( '/help/' )           => __( 'Help Center', 'fleetmonitor' ),
							home_url( '/contact/' )        => __( 'Contact Us', 'fleetmonitor' ),
							home_url( '/documentation/' )  => __( 'Documentation', 'fleetmonitor' ),
							home_url( '/api/' )            => __( 'API Reference', 'fleetmonitor' ),
							home_url( '/status/' )         => __( 'System Status', 'fleetmonitor' ),
							home_url( '/community/' )      => __( 'Community Forum', 'fleetmonitor' ),
						);
						foreach ( $links as $url => $label ) {
							printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
						}
						echo '</ul>';
					}
					?>
				</div>

			</div><!-- .footer-grid -->
		</div><!-- .container -->
	</div><!-- .footer-main -->

	<!-- Footer Bottom Bar -->
	<div class="footer-bottom">
		<div class="container">
			<div class="footer-bottom-inner">

				<p class="footer-copyright">
					<?php
					printf(
						/* translators: 1: year, 2: site name */
						esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'fleetmonitor' ),
						esc_html( gmdate( 'Y' ) ),
						esc_html( get_bloginfo( 'name' ) )
					);
					?>
				</p>

				<nav class="footer-legal-links" aria-label="<?php esc_attr_e( 'Legal links', 'fleetmonitor' ); ?>">
					<?php
					if ( has_nav_menu( 'legal' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'legal',
								'container'      => false,
								'depth'          => 1,
							)
						);
					} else {
						$legal = array(
							home_url( '/privacy-policy/' )   => __( 'Privacy Policy', 'fleetmonitor' ),
							home_url( '/terms-of-service/' ) => __( 'Terms of Service', 'fleetmonitor' ),
							home_url( '/cookie-policy/' )    => __( 'Cookies', 'fleetmonitor' ),
							home_url( '/gdpr/' )             => __( 'GDPR', 'fleetmonitor' ),
						);
						foreach ( $legal as $url => $label ) {
							printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
						}
					}
					?>
				</nav>

				<!-- Payment icons -->
				<div class="footer-payments" aria-label="<?php esc_attr_e( 'Accepted payment methods', 'fleetmonitor' ); ?>">
					<span class="payment-icon">VISA</span>
					<span class="payment-icon">MC</span>
					<span class="payment-icon">AMEX</span>
					<span class="payment-icon">PAYPAL</span>
					<span class="payment-icon">BLIK</span>
				</div>

			</div>
		</div>
	</div><!-- .footer-bottom -->

</footer><!-- .site-footer -->

<!-- Scroll to Top Button -->
<button id="scroll-top" aria-label="<?php esc_attr_e( 'Scroll to top', 'fleetmonitor' ); ?>">
	<?php echo fleetmonitor_icon( 'arrow-up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
</button>

<?php wp_footer(); ?>
</body>
</html>
