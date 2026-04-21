<?php
/**
 * Contact page template
 *
 * Template Name: Contact Page
 *
 * @package FleetMonitor
 */

get_header();
?>

<div class="page-hero">
	<div class="container">
		<h1 class="page-hero-title"><?php esc_html_e( 'Contact Us', 'fleetmonitor' ); ?></h1>
		<p class="page-hero-subtitle">
			<?php esc_html_e( 'Get in touch with our team. We respond within 1 business day.', 'fleetmonitor' ); ?>
		</p>
	</div>
</div>

<section class="contact-section">
	<div class="container">
		<div class="contact-grid">

			<!-- Contact Form Card -->
			<div class="contact-form-card">
				<h2 style="font-size:1.5rem; font-weight:700; color:var(--color-primary); margin-bottom:.5rem;">
					<?php esc_html_e( 'Send us a message', 'fleetmonitor' ); ?>
				</h2>
				<p style="font-size:.875rem; color:var(--color-gray-600); margin-bottom:2rem;">
					<?php esc_html_e( 'Fill out the form below and we\'ll get back to you as soon as possible.', 'fleetmonitor' ); ?>
				</p>

				<div id="contact-form-response" class="alert" style="display:none;" role="alert" aria-live="polite"></div>

				<form class="fm-form" id="contact-form" novalidate>
					<?php wp_nonce_field( 'fleetmonitor_nonce', 'nonce' ); ?>

					<div class="form-row">
						<div class="form-group">
							<label for="contact-name"><?php esc_html_e( 'Full Name', 'fleetmonitor' ); ?> <span aria-hidden="true" style="color:var(--color-danger);">*</span></label>
							<input type="text" id="contact-name" name="name" required autocomplete="name"
							       placeholder="<?php esc_attr_e( 'Jan Kowalski', 'fleetmonitor' ); ?>">
						</div>
						<div class="form-group">
							<label for="contact-email"><?php esc_html_e( 'Email Address', 'fleetmonitor' ); ?> <span aria-hidden="true" style="color:var(--color-danger);">*</span></label>
							<input type="email" id="contact-email" name="email" required autocomplete="email"
							       placeholder="<?php esc_attr_e( 'jan@firma.pl', 'fleetmonitor' ); ?>">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group">
							<label for="contact-company"><?php esc_html_e( 'Company Name', 'fleetmonitor' ); ?></label>
							<input type="text" id="contact-company" name="company" autocomplete="organization"
							       placeholder="<?php esc_attr_e( 'Twoja Firma Sp. z o.o.', 'fleetmonitor' ); ?>">
						</div>
						<div class="form-group">
							<label for="contact-phone"><?php esc_html_e( 'Phone Number', 'fleetmonitor' ); ?></label>
							<input type="tel" id="contact-phone" name="phone" autocomplete="tel"
							       placeholder="<?php esc_attr_e( '+48 000 000 000', 'fleetmonitor' ); ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="contact-fleet-size"><?php esc_html_e( 'Fleet Size', 'fleetmonitor' ); ?></label>
						<select id="contact-fleet-size" name="fleet_size">
							<option value=""><?php esc_html_e( '-- Select fleet size --', 'fleetmonitor' ); ?></option>
							<option value="1-5"><?php esc_html_e( '1–5 vehicles', 'fleetmonitor' ); ?></option>
							<option value="6-25"><?php esc_html_e( '6–25 vehicles', 'fleetmonitor' ); ?></option>
							<option value="26-100"><?php esc_html_e( '26–100 vehicles', 'fleetmonitor' ); ?></option>
							<option value="100+"><?php esc_html_e( '100+ vehicles', 'fleetmonitor' ); ?></option>
						</select>
					</div>

					<div class="form-group">
						<label for="contact-subject"><?php esc_html_e( 'Subject', 'fleetmonitor' ); ?></label>
						<select id="contact-subject" name="subject">
							<option value="general"><?php esc_html_e( 'General enquiry', 'fleetmonitor' ); ?></option>
							<option value="sales"><?php esc_html_e( 'Sales & pricing', 'fleetmonitor' ); ?></option>
							<option value="support"><?php esc_html_e( 'Technical support', 'fleetmonitor' ); ?></option>
							<option value="partnership"><?php esc_html_e( 'Partnership', 'fleetmonitor' ); ?></option>
							<option value="demo"><?php esc_html_e( 'Request a demo', 'fleetmonitor' ); ?></option>
						</select>
					</div>

					<div class="form-group">
						<label for="contact-message"><?php esc_html_e( 'Message', 'fleetmonitor' ); ?> <span aria-hidden="true" style="color:var(--color-danger);">*</span></label>
						<textarea id="contact-message" name="message" required rows="5"
						          placeholder="<?php esc_attr_e( 'Tell us about your fleet and what you\'d like to achieve…', 'fleetmonitor' ); ?>"></textarea>
					</div>

					<div class="form-group">
						<label style="display:flex; align-items:flex-start; gap:.5rem; font-weight:400; cursor:pointer;">
							<input type="checkbox" name="gdpr" required style="margin-top:3px; width:auto;">
							<span style="font-size:.8rem; color:var(--color-gray-600);">
								<?php
								printf(
									/* translators: %1$s, %2$s: HTML links */
									esc_html__( 'I agree to the %1$sPrivacy Policy%2$s and consent to processing my data.', 'fleetmonitor' ),
									'<a href="' . esc_url( home_url( '/privacy-policy/' ) ) . '" target="_blank">',
									'</a>'
								);
								?>
							</span>
						</label>
					</div>

					<button type="submit" class="btn btn-primary w-full" id="contact-submit">
						<?php esc_html_e( 'Send Message', 'fleetmonitor' ); ?>
					</button>
				</form>
			</div><!-- .contact-form-card -->

			<!-- Contact Info Card -->
			<div class="contact-info-card">
				<h2 style="font-size:1.5rem; font-weight:700; color:white; margin-bottom:2rem;">
					<?php esc_html_e( 'Get in touch', 'fleetmonitor' ); ?>
				</h2>

				<?php
				$info_items = array(
					array(
						'icon'    => 'phone',
						'label'   => __( 'Phone', 'fleetmonitor' ),
						'value'   => get_theme_mod( 'company_phone', '+48 22 123 456 789' ),
						'href'    => 'tel:' . preg_replace( '/[^+\d]/', '', get_theme_mod( 'company_phone', '+48221234567' ) ),
					),
					array(
						'icon'    => 'mail',
						'label'   => __( 'Email', 'fleetmonitor' ),
						'value'   => get_theme_mod( 'company_email', 'contact@fleetmonitor.pro' ),
						'href'    => 'mailto:' . get_theme_mod( 'company_email', 'contact@fleetmonitor.pro' ),
					),
					array(
						'icon'    => 'address',
						'label'   => __( 'Address', 'fleetmonitor' ),
						'value'   => get_theme_mod( 'company_address', 'ul. Technologiczna 15, 00-001 Warszawa, Poland' ),
						'href'    => '',
					),
				);
				foreach ( $info_items as $item ) :
				?>
				<div style="display:flex; gap:1rem; align-items:flex-start; margin-bottom:1.5rem;">
					<div style="width:44px; height:44px; background:rgba(255,255,255,.1); border-radius:var(--radius-lg); display:flex; align-items:center; justify-content:center; flex-shrink:0; color:white;">
						<?php echo fleetmonitor_icon( $item['icon'] ); // phpcs:ignore ?>
					</div>
					<div>
						<div style="font-size:.75rem; color:rgba(255,255,255,.55); text-transform:uppercase; letter-spacing:.08em; font-weight:600; margin-bottom:.25rem;">
							<?php echo esc_html( $item['label'] ); ?>
						</div>
						<?php if ( $item['href'] ) : ?>
							<a href="<?php echo esc_url( $item['href'] ); ?>" style="color:rgba(255,255,255,.85); font-size:.9rem;">
								<?php echo esc_html( $item['value'] ); ?>
							</a>
						<?php else : ?>
							<span style="color:rgba(255,255,255,.85); font-size:.9rem;">
								<?php echo esc_html( $item['value'] ); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>
				<?php endforeach; ?>

				<div style="margin-top:2.5rem; padding-top:2rem; border-top:1px solid rgba(255,255,255,.1);">
					<h3 style="font-size:.875rem; font-weight:700; color:white; text-transform:uppercase; letter-spacing:.08em; margin-bottom:1rem;">
						<?php esc_html_e( 'Office Hours', 'fleetmonitor' ); ?>
					</h3>
					<p style="font-size:.85rem; color:rgba(255,255,255,.65); margin-bottom:.5rem;">
						<?php esc_html_e( 'Monday – Friday: 8:00 – 18:00 CET', 'fleetmonitor' ); ?>
					</p>
					<p style="font-size:.85rem; color:rgba(255,255,255,.65);">
						<?php esc_html_e( 'Saturday: 9:00 – 14:00 CET', 'fleetmonitor' ); ?>
					</p>
					<p style="font-size:.85rem; color:rgba(40,167,69,.8); margin-top:1rem; font-weight:600;">
						<?php esc_html_e( '🟢 Technical support available 24/7', 'fleetmonitor' ); ?>
					</p>
				</div>

			</div><!-- .contact-info-card -->

		</div><!-- .contact-grid -->
	</div><!-- .container -->
</section>

<!-- Map placeholder (replace with real Google Maps embed) -->
<div style="height:400px; background:var(--color-gray-200); position:relative; overflow:hidden;">
	<div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg, var(--color-primary) 0%, #0f3460 100%); opacity:.05;"></div>
	<div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; color:var(--color-gray-500);">
		<?php echo fleetmonitor_icon( 'map' ); // phpcs:ignore ?>
		<p style="margin-top:.5rem; font-size:.875rem;">
			<?php esc_html_e( 'Map — add your Google Maps embed here', 'fleetmonitor' ); ?>
		</p>
		<?php
		// Google Maps embed placeholder comment
		echo '<!-- To add a Google Maps embed, replace this placeholder with:';
		echo "\n<!-- <iframe src=\"https://www.google.com/maps/embed?...\" width=\"100%\" height=\"400\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe> -->";
		echo "\n";
		?>
	</div>
</div>

<?php get_footer(); ?>
