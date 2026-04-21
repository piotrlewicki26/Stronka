<?php
/**
 * The front page template – homepage
 *
 * @package FleetMonitor
 */

get_header();
?>

<!-- =====================================================
     HERO SECTION
     ===================================================== -->
<section class="hero-section" id="hero" aria-label="<?php esc_attr_e( 'Hero', 'fleetmonitor' ); ?>">
	<div class="hero-bg-pattern" aria-hidden="true"></div>
	<div class="hero-grid-overlay" aria-hidden="true"></div>

	<div class="hero-content container">
		<div class="hero-inner">

			<!-- Hero Text -->
			<div class="hero-text">
				<div class="badge badge-white">
					<span class="live-dot" aria-hidden="true"></span>
					<?php esc_html_e( 'Live GPS Tracking &amp; Fleet Management', 'fleetmonitor' ); ?>
				</div>

				<h1 class="hero-headline">
					<?php
					$headline = get_theme_mod( 'hero_headline', __( 'Track Every Vehicle. Manage Every Mile.', 'fleetmonitor' ) );
					// Wrap last word in accent colour
					$words     = explode( ' ', $headline );
					$last_word = array_pop( $words );
					echo esc_html( implode( ' ', $words ) ) . ' <span class="highlight">' . esc_html( $last_word ) . '</span>';
					?>
				</h1>

				<p class="hero-description">
					<?php echo esc_html( get_theme_mod( 'hero_description', __( 'Professional GPS fleet management platform. Real-time tracking, route optimisation, driver analytics and a full WooCommerce store for GPS hardware and subscriptions.', 'fleetmonitor' ) ) ); ?>
				</p>

				<div class="hero-actions">
					<a href="<?php echo esc_url( get_theme_mod( 'hero_primary_btn_url', '#pricing' ) ); ?>" class="btn btn-primary btn-lg">
						<?php echo esc_html( get_theme_mod( 'hero_primary_btn_text', __( 'Start Free Trial', 'fleetmonitor' ) ) ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/demo/' ) ); ?>" class="btn btn-outline-white btn-lg">
						<?php echo fleetmonitor_icon( 'play' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<?php esc_html_e( 'Watch Demo', 'fleetmonitor' ); ?>
					</a>
				</div>

				<div class="hero-stats" role="list">
					<div class="hero-stat" role="listitem">
						<span class="hero-stat-value"><?php echo esc_html( get_theme_mod( 'stat_1_value', '50,000+' ) ); ?></span>
						<span class="hero-stat-label"><?php echo esc_html( get_theme_mod( 'stat_1_label', __( 'Vehicles Tracked', 'fleetmonitor' ) ) ); ?></span>
					</div>
					<div class="hero-stat" role="listitem">
						<span class="hero-stat-value"><?php echo esc_html( get_theme_mod( 'stat_2_value', '2,500+' ) ); ?></span>
						<span class="hero-stat-label"><?php echo esc_html( get_theme_mod( 'stat_2_label', __( 'Business Clients', 'fleetmonitor' ) ) ); ?></span>
					</div>
					<div class="hero-stat" role="listitem">
						<span class="hero-stat-value"><?php echo esc_html( get_theme_mod( 'stat_3_value', '99.9%' ) ); ?></span>
						<span class="hero-stat-label"><?php echo esc_html( get_theme_mod( 'stat_3_label', __( 'Uptime SLA', 'fleetmonitor' ) ) ); ?></span>
					</div>
				</div>
			</div><!-- .hero-text -->

			<!-- Hero Visual / Map Card -->
			<div class="hero-visual" aria-hidden="true">
				<div class="hero-map-card">

					<!-- Header row -->
					<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
						<span style="font-size:.875rem; font-weight:600; color:#fff;">
							<?php esc_html_e( 'Live Fleet Map', 'fleetmonitor' ); ?>
						</span>
						<span class="live-tracking-badge">
							<span class="live-dot"></span>
							<?php esc_html_e( 'LIVE', 'fleetmonitor' ); ?>
						</span>
					</div>

					<!-- Map placeholder -->
					<div class="map-placeholder">
						<!-- Stylised map SVG background -->
						<svg class="map-svg" viewBox="0 0 480 280" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<!-- Road network lines -->
							<line x1="0" y1="140" x2="480" y2="140" stroke="rgba(14,122,254,.25)" stroke-width="2"/>
							<line x1="240" y1="0" x2="240" y2="280" stroke="rgba(14,122,254,.25)" stroke-width="2"/>
							<line x1="0" y1="70" x2="480" y2="210" stroke="rgba(14,122,254,.12)" stroke-width="1.5"/>
							<line x1="0" y1="210" x2="480" y2="70" stroke="rgba(14,122,254,.12)" stroke-width="1.5"/>
							<!-- City blocks -->
							<rect x="60" y="40" width="80" height="60" rx="4" fill="rgba(14,122,254,.06)" stroke="rgba(14,122,254,.12)" stroke-width="1"/>
							<rect x="180" y="40" width="80" height="60" rx="4" fill="rgba(14,122,254,.06)" stroke="rgba(14,122,254,.12)" stroke-width="1"/>
							<rect x="340" y="40" width="80" height="60" rx="4" fill="rgba(14,122,254,.06)" stroke="rgba(14,122,254,.12)" stroke-width="1"/>
							<rect x="60" y="180" width="80" height="60" rx="4" fill="rgba(14,122,254,.06)" stroke="rgba(14,122,254,.12)" stroke-width="1"/>
							<rect x="180" y="160" width="100" height="80" rx="4" fill="rgba(14,122,254,.06)" stroke="rgba(14,122,254,.12)" stroke-width="1"/>
							<rect x="340" y="180" width="80" height="60" rx="4" fill="rgba(14,122,254,.06)" stroke="rgba(14,122,254,.12)" stroke-width="1"/>
							<!-- Route path -->
							<path d="M80 200 Q150 140 240 120 Q320 100 400 80" stroke="#0e7afe" stroke-width="2.5" fill="none" stroke-dasharray="6 3" opacity=".7"/>
						</svg>

						<!-- Vehicle pins -->
						<div class="vehicle-pin vehicle-pin-1" title="<?php esc_attr_e( 'Vehicle 1 – en route', 'fleetmonitor' ); ?>">
							<?php echo fleetmonitor_icon( 'truck' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						</div>
						<div class="vehicle-pin vehicle-pin-2" title="<?php esc_attr_e( 'Vehicle 2 – en route', 'fleetmonitor' ); ?>">
							<?php echo fleetmonitor_icon( 'truck' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						</div>
						<div class="vehicle-pin vehicle-pin-3" title="<?php esc_attr_e( 'Vehicle 3 – en route', 'fleetmonitor' ); ?>">
							<?php echo fleetmonitor_icon( 'truck' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						</div>
					</div>

					<!-- Mini stats row -->
					<div class="map-stats-row">
						<div class="map-stat">
							<div class="map-stat-value">24</div>
							<div class="map-stat-label"><?php esc_html_e( 'Active', 'fleetmonitor' ); ?></div>
						</div>
						<div class="map-stat">
							<div class="map-stat-value">3</div>
							<div class="map-stat-label"><?php esc_html_e( 'Idle', 'fleetmonitor' ); ?></div>
						</div>
						<div class="map-stat">
							<div class="map-stat-value">1</div>
							<div class="map-stat-label"><?php esc_html_e( 'Alert', 'fleetmonitor' ); ?></div>
						</div>
					</div>

				</div><!-- .hero-map-card -->

				<!-- Floating cards -->
				<div class="floating-card floating-card-1">
					<div class="floating-card-icon green">
						<?php echo fleetmonitor_icon( 'chart' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</div>
					<div class="floating-card-text">
						<div class="label"><?php esc_html_e( 'Fuel Saved', 'fleetmonitor' ); ?></div>
						<div class="value">↓ 23% <?php esc_html_e( 'this month', 'fleetmonitor' ); ?></div>
					</div>
				</div>

				<div class="floating-card floating-card-2">
					<div class="floating-card-icon blue">
						<?php echo fleetmonitor_icon( 'shield' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</div>
					<div class="floating-card-text">
						<div class="label"><?php esc_html_e( 'Safety Score', 'fleetmonitor' ); ?></div>
						<div class="value">98/100 <?php esc_html_e( 'Excellent', 'fleetmonitor' ); ?></div>
					</div>
				</div>

			</div><!-- .hero-visual -->

		</div><!-- .hero-inner -->
	</div><!-- .hero-content -->
</section><!-- .hero-section -->

<!-- =====================================================
     TRUSTED BY SECTION
     ===================================================== -->
<section class="trusted-section" aria-label="<?php esc_attr_e( 'Trusted by leading companies', 'fleetmonitor' ); ?>">
	<div class="container">
		<p class="trusted-label"><?php esc_html_e( 'Trusted by 2,500+ companies worldwide', 'fleetmonitor' ); ?></p>
		<div class="logos-grid" role="list">
			<?php
			$companies = array(
				'DHL Logistics', 'FedEx Express', 'Amazon Delivery',
				'UPS Fleet', 'DB Schenker', 'Raben Group',
			);
			foreach ( $companies as $company ) {
				printf( '<span class="logo-item" role="listitem">%s</span>', esc_html( $company ) );
			}
			?>
		</div>
	</div>
</section>

<!-- =====================================================
     FEATURES SECTION
     ===================================================== -->
<section class="section features-section" id="features" aria-labelledby="features-title">
	<div class="container">
		<header class="section-header text-center">
			<div class="badge badge-accent"><?php esc_html_e( 'Platform Features', 'fleetmonitor' ); ?></div>
			<h2 class="section-title" id="features-title">
				<?php esc_html_e( 'Everything You Need to Manage Your Fleet', 'fleetmonitor' ); ?>
			</h2>
			<p class="section-subtitle">
				<?php esc_html_e( 'From real-time GPS tracking to advanced analytics, our platform gives you complete visibility and control over every vehicle in your fleet.', 'fleetmonitor' ); ?>
			</p>
		</header>

		<div class="features-grid" role="list">

			<?php
			$features = array(
				array(
					'icon'  => 'location-pin',
					'color' => 'blue',
					'title' => __( 'Real-Time GPS Tracking', 'fleetmonitor' ),
					'desc'  => __( 'Monitor all vehicles live on an interactive map with sub-second location updates, historical playback, and geofencing alerts.', 'fleetmonitor' ),
					'items' => array(
						__( 'Live position updates every 5 seconds', 'fleetmonitor' ),
						__( 'Interactive map with satellite view', 'fleetmonitor' ),
						__( 'Geofence entry/exit notifications', 'fleetmonitor' ),
						__( 'Trip history & route replay', 'fleetmonitor' ),
					),
				),
				array(
					'icon'  => 'chart',
					'color' => 'green',
					'title' => __( 'Fleet Analytics & Reports', 'fleetmonitor' ),
					'desc'  => __( 'Comprehensive dashboards with KPIs, automated reporting, and data-driven insights to optimise your operations and cut costs.', 'fleetmonitor' ),
					'items' => array(
						__( 'Customisable dashboards & widgets', 'fleetmonitor' ),
						__( 'Automated daily/weekly PDF reports', 'fleetmonitor' ),
						__( 'Fuel consumption analysis', 'fleetmonitor' ),
						__( 'Cost-per-km calculations', 'fleetmonitor' ),
					),
				),
				array(
					'icon'  => 'truck',
					'color' => 'orange',
					'title' => __( 'Driver Behaviour Monitoring', 'fleetmonitor' ),
					'desc'  => __( 'Improve safety and reduce insurance costs by monitoring harsh braking, acceleration, speeding and other risky driving events.', 'fleetmonitor' ),
					'items' => array(
						__( 'Harsh braking & acceleration detection', 'fleetmonitor' ),
						__( 'Speed limit monitoring', 'fleetmonitor' ),
						__( 'Driver scorecard & ranking', 'fleetmonitor' ),
						__( 'Fatigue & idle time alerts', 'fleetmonitor' ),
					),
				),
				array(
					'icon'  => 'settings',
					'color' => 'purple',
					'title' => __( 'Maintenance Management', 'fleetmonitor' ),
					'desc'  => __( 'Never miss a service with automated maintenance reminders based on mileage, engine hours or calendar schedules.', 'fleetmonitor' ),
					'items' => array(
						__( 'Service interval tracking', 'fleetmonitor' ),
						__( 'Vehicle inspection checklists', 'fleetmonitor' ),
						__( 'Repair history & cost logging', 'fleetmonitor' ),
						__( 'Document & certificate management', 'fleetmonitor' ),
					),
				),
				array(
					'icon'  => 'map',
					'color' => 'teal',
					'title' => __( 'Route Optimisation', 'fleetmonitor' ),
					'desc'  => __( 'Intelligent routing algorithms that minimise travel time, reduce fuel costs, and improve on-time delivery performance.', 'fleetmonitor' ),
					'items' => array(
						__( 'Multi-stop route planning', 'fleetmonitor' ),
						__( 'Traffic-aware navigation', 'fleetmonitor' ),
						__( 'ETA calculation & customer alerts', 'fleetmonitor' ),
						__( 'Delivery proof of completion', 'fleetmonitor' ),
					),
				),
				array(
					'icon'  => 'alert',
					'color' => 'red',
					'title' => __( 'Alerts & Notifications', 'fleetmonitor' ),
					'desc'  => __( 'Stay informed with instant alerts for speeding, unauthorised use, breakdown, battery low, and dozens of other critical events.', 'fleetmonitor' ),
					'items' => array(
						__( 'Real-time SMS & email alerts', 'fleetmonitor' ),
						__( 'Mobile push notifications', 'fleetmonitor' ),
						__( 'Custom alert rule builder', 'fleetmonitor' ),
						__( 'On-call escalation workflows', 'fleetmonitor' ),
					),
				),
			);

			foreach ( $features as $feature ) :
			?>
			<div class="feature-card" role="listitem">
				<div class="feature-icon <?php echo esc_attr( $feature['color'] ); ?>" aria-hidden="true">
					<?php echo fleetmonitor_icon( $feature['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</div>
				<h3 class="feature-title"><?php echo esc_html( $feature['title'] ); ?></h3>
				<p class="feature-description"><?php echo esc_html( $feature['desc'] ); ?></p>
				<ul class="feature-list" aria-label="<?php esc_attr_e( 'Key capabilities', 'fleetmonitor' ); ?>">
					<?php foreach ( $feature['items'] as $item ) : ?>
						<li><?php echo esc_html( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endforeach; ?>

		</div><!-- .features-grid -->
	</div><!-- .container -->
</section><!-- .features-section -->

<!-- =====================================================
     STATS SECTION
     ===================================================== -->
<section class="stats-section" aria-label="<?php esc_attr_e( 'Key statistics', 'fleetmonitor' ); ?>">
	<div class="container">
		<div class="stats-grid" role="list">
			<?php
			for ( $i = 1; $i <= 4; $i++ ) {
				$defaults = array(
					1 => array( 'value' => '50,000+', 'label' => __( 'Vehicles Tracked', 'fleetmonitor' ) ),
					2 => array( 'value' => '2,500+',  'label' => __( 'Business Clients', 'fleetmonitor' ) ),
					3 => array( 'value' => '99.9%',   'label' => __( 'Uptime SLA', 'fleetmonitor' ) ),
					4 => array( 'value' => '24/7',    'label' => __( 'Expert Support', 'fleetmonitor' ) ),
				);
				$value = get_theme_mod( "stat_{$i}_value", $defaults[ $i ]['value'] );
				$label = get_theme_mod( "stat_{$i}_label", $defaults[ $i ]['label'] );
				?>
				<div class="stat-item" role="listitem">
					<div class="stat-number" data-count="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $value ); ?></div>
					<div class="stat-label"><?php echo esc_html( $label ); ?></div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>

<!-- =====================================================
     FEATURED PRODUCTS SECTION (WooCommerce)
     ===================================================== -->
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<section class="section products-section" id="products" aria-labelledby="products-title">
	<div class="container">
		<header class="section-header text-center">
			<div class="badge badge-accent"><?php esc_html_e( 'GPS Hardware Store', 'fleetmonitor' ); ?></div>
			<h2 class="section-title" id="products-title">
				<?php esc_html_e( 'Professional GPS Tracking Devices', 'fleetmonitor' ); ?>
			</h2>
			<p class="section-subtitle">
				<?php esc_html_e( 'Order top-rated GPS trackers, OBD dongles, dashcams and fleet management hardware, delivered worldwide.', 'fleetmonitor' ); ?>
			</p>
		</header>

		<?php
		$featured_products = new WP_Query(
			array(
				'post_type'      => 'product',
				'posts_per_page' => 4,
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					),
				),
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery
					array(
						'key'     => '_stock_status',
						'value'   => 'instock',
						'compare' => '=',
					),
				),
			)
		);

		// If no featured products, fall back to latest products
		if ( ! $featured_products->have_posts() ) {
			$featured_products = new WP_Query(
				array(
					'post_type'      => 'product',
					'posts_per_page' => 4,
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);
		}
		?>

		<?php if ( $featured_products->have_posts() ) : ?>
			<div class="products-grid woocommerce" role="list">
				<?php
				wc_set_loop_prop( 'columns', 4 );
				while ( $featured_products->have_posts() ) {
					$featured_products->the_post();
					global $product;
					if ( ! $product ) {
						continue;
					}
					wc_get_template_part( 'content', 'product' );
				}
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<!-- Placeholder cards when no products yet -->
			<div class="products-grid">
				<?php
				$placeholder_products = array(
					array(
						'badge' => 'new', 'badge_text' => __( 'New', 'fleetmonitor' ),
						'cat'  => __( 'GPS Tracker', 'fleetmonitor' ),
						'name' => __( 'FleetTrack Pro X200', 'fleetmonitor' ),
						'price' => '299.99', 'old_price' => '',
						'stars' => 5, 'reviews' => 128,
					),
					array(
						'badge' => 'popular', 'badge_text' => __( 'Popular', 'fleetmonitor' ),
						'cat'  => __( 'OBD Device', 'fleetmonitor' ),
						'name' => __( 'OBD Connect Elite', 'fleetmonitor' ),
						'price' => '149.99', 'old_price' => '199.99',
						'stars' => 5, 'reviews' => 84,
					),
					array(
						'badge' => 'sale', 'badge_text' => __( 'Sale', 'fleetmonitor' ),
						'cat'  => __( 'Dashcam', 'fleetmonitor' ),
						'name' => __( 'DriveSafe 4K Dashcam', 'fleetmonitor' ),
						'price' => '219.99', 'old_price' => '279.99',
						'stars' => 4, 'reviews' => 56,
					),
					array(
						'badge' => '', 'badge_text' => '',
						'cat'  => __( 'Software', 'fleetmonitor' ),
						'name' => __( 'FleetMonitor SaaS Pro', 'fleetmonitor' ),
						'price' => '49.99', 'old_price' => '',
						'stars' => 5, 'reviews' => 210,
					),
				);

				foreach ( $placeholder_products as $p ) :
				?>
				<article class="product-card" role="listitem">
					<?php if ( $p['badge'] ) : ?>
						<span class="product-badge <?php echo esc_attr( $p['badge'] ); ?>"><?php echo esc_html( $p['badge_text'] ); ?></span>
					<?php endif; ?>

					<div class="product-image-wrap">
						<!-- SVG placeholder device illustration -->
						<svg width="120" height="120" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<rect x="20" y="20" width="80" height="80" rx="16" fill="#e8f3ff" stroke="#0e7afe" stroke-width="2"/>
							<rect x="35" y="35" width="50" height="34" rx="6" fill="#0e7afe" opacity=".15"/>
							<circle cx="60" cy="52" r="12" fill="#0e7afe" opacity=".3"/>
							<circle cx="60" cy="52" r="6" fill="#0e7afe"/>
							<rect x="45" y="78" width="30" height="6" rx="3" fill="#0e7afe" opacity=".3"/>
						</svg>
						<div class="product-quick-actions">
							<button class="product-quick-btn" aria-label="<?php esc_attr_e( 'Add to wishlist', 'fleetmonitor' ); ?>">♡</button>
							<button class="product-quick-btn" aria-label="<?php esc_attr_e( 'Quick view', 'fleetmonitor' ); ?>">⊕</button>
						</div>
					</div>

					<div class="product-info">
						<div class="product-category"><?php echo esc_html( $p['cat'] ); ?></div>
						<h3 class="product-name"><?php echo esc_html( $p['name'] ); ?></h3>
						<div class="product-rating">
							<span class="stars" aria-label="<?php printf( esc_attr__( '%d stars', 'fleetmonitor' ), $p['stars'] ); ?>">
								<?php echo str_repeat( '★', (int) $p['stars'] ) . str_repeat( '☆', 5 - (int) $p['stars'] ); // phpcs:ignore ?>
							</span>
							<span class="review-count">(<?php echo esc_html( $p['reviews'] ); ?>)</span>
						</div>
						<div class="product-footer">
							<div class="product-price">
								<?php if ( $p['old_price'] ) : ?>
									<span class="original">€<?php echo esc_html( $p['old_price'] ); ?></span>
								<?php endif; ?>
								€<?php echo esc_html( $p['price'] ); ?>
							</div>
							<?php if ( class_exists( 'WooCommerce' ) ) : ?>
								<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn-add-to-cart">
									<?php esc_html_e( 'Add to Cart', 'fleetmonitor' ); ?>
								</a>
							<?php else : ?>
								<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="btn-add-to-cart">
									<?php esc_html_e( 'View Product', 'fleetmonitor' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="text-center" style="margin-top: 3rem;">
			<a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) : esc_url( home_url( '/shop/' ) ); ?>" class="btn btn-primary btn-lg">
				<?php esc_html_e( 'Browse All Products', 'fleetmonitor' ); ?>
				<?php echo fleetmonitor_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</a>
		</div>
	</div><!-- .container -->
</section>
<?php endif; ?>

<!-- =====================================================
     PRICING SECTION
     ===================================================== -->
<section class="section pricing-section" id="pricing" aria-labelledby="pricing-title">
	<div class="container">
		<header class="section-header text-center">
			<div class="badge badge-accent"><?php esc_html_e( 'Software Plans', 'fleetmonitor' ); ?></div>
			<h2 class="section-title" id="pricing-title">
				<?php esc_html_e( 'Simple, Transparent Pricing', 'fleetmonitor' ); ?>
			</h2>
			<p class="section-subtitle">
				<?php esc_html_e( 'Choose the plan that fits your fleet size. No hidden fees. Scale up or down at any time.', 'fleetmonitor' ); ?>
			</p>
		</header>

		<!-- Billing toggle -->
		<div class="pricing-toggle" role="group" aria-label="<?php esc_attr_e( 'Billing period', 'fleetmonitor' ); ?>">
			<span class="toggle-label active" id="toggle-monthly"><?php esc_html_e( 'Monthly', 'fleetmonitor' ); ?></span>
			<button class="toggle-switch" id="billing-toggle" role="switch" aria-checked="false" aria-labelledby="toggle-monthly toggle-annual"></button>
			<span class="toggle-label" id="toggle-annual">
				<?php esc_html_e( 'Annual', 'fleetmonitor' ); ?>
				<span class="save-badge"><?php esc_html_e( 'Save 20%', 'fleetmonitor' ); ?></span>
			</span>
		</div>

		<div class="pricing-grid" role="list">

			<!-- Starter Plan -->
			<div class="pricing-card" role="listitem">
				<h3 class="pricing-plan-name"><?php esc_html_e( 'Starter', 'fleetmonitor' ); ?></h3>
				<p class="pricing-plan-description"><?php esc_html_e( 'Perfect for small businesses just getting started with GPS tracking.', 'fleetmonitor' ); ?></p>
				<div class="pricing-price">
					<div class="pricing-amount">
						<span class="pricing-currency">€</span><span class="price-value" data-monthly="29" data-annual="23">29</span>
					</div>
					<div class="pricing-period"><?php esc_html_e( 'per month', 'fleetmonitor' ); ?></div>
				</div>
				<div class="pricing-vehicles"><?php esc_html_e( 'Up to 5 vehicles', 'fleetmonitor' ); ?></div>
				<div class="pricing-divider"></div>
				<ul class="pricing-features" aria-label="<?php esc_attr_e( 'Starter plan features', 'fleetmonitor' ); ?>">
					<?php
					$starter_features = array(
						array( true,  __( 'Real-time GPS tracking', 'fleetmonitor' ) ),
						array( true,  __( 'Basic reports & history', 'fleetmonitor' ) ),
						array( true,  __( 'Email alerts', 'fleetmonitor' ) ),
						array( true,  __( 'Mobile app (iOS & Android)', 'fleetmonitor' ) ),
						array( false, __( 'Driver behaviour monitoring', 'fleetmonitor' ) ),
						array( false, __( 'Route optimisation', 'fleetmonitor' ) ),
						array( false, __( 'API access', 'fleetmonitor' ) ),
					);
					foreach ( $starter_features as $f ) :
					?>
					<li class="pricing-feature">
						<span class="<?php echo $f[0] ? 'check' : 'cross'; ?>" aria-hidden="true">
							<?php echo fleetmonitor_icon( $f[0] ? 'check' : 'close' ); // phpcs:ignore ?>
						</span>
						<span><?php echo esc_html( $f[1] ); ?></span>
					</li>
					<?php endforeach; ?>
				</ul>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-secondary w-full">
					<?php esc_html_e( 'Get Started', 'fleetmonitor' ); ?>
				</a>
			</div>

			<!-- Professional Plan (Featured) -->
			<div class="pricing-card featured" role="listitem">
				<div class="popular-tag"><?php esc_html_e( '⭐ Most Popular', 'fleetmonitor' ); ?></div>
				<h3 class="pricing-plan-name"><?php esc_html_e( 'Professional', 'fleetmonitor' ); ?></h3>
				<p class="pricing-plan-description"><?php esc_html_e( 'Full-featured platform for growing businesses with medium-size fleets.', 'fleetmonitor' ); ?></p>
				<div class="pricing-price">
					<div class="pricing-amount">
						<span class="pricing-currency">€</span><span class="price-value" data-monthly="79" data-annual="63">79</span>
					</div>
					<div class="pricing-period"><?php esc_html_e( 'per month', 'fleetmonitor' ); ?></div>
				</div>
				<div class="pricing-vehicles"><?php esc_html_e( 'Up to 25 vehicles', 'fleetmonitor' ); ?></div>
				<div class="pricing-divider"></div>
				<ul class="pricing-features" aria-label="<?php esc_attr_e( 'Professional plan features', 'fleetmonitor' ); ?>">
					<?php
					$pro_features = array(
						array( true, __( 'Everything in Starter', 'fleetmonitor' ) ),
						array( true, __( 'Driver behaviour monitoring', 'fleetmonitor' ) ),
						array( true, __( 'Route optimisation', 'fleetmonitor' ) ),
						array( true, __( 'Fuel management reports', 'fleetmonitor' ) ),
						array( true, __( 'Maintenance scheduling', 'fleetmonitor' ) ),
						array( true, __( 'SMS & push notifications', 'fleetmonitor' ) ),
						array( false, __( 'Custom API integrations', 'fleetmonitor' ) ),
					);
					foreach ( $pro_features as $f ) :
					?>
					<li class="pricing-feature">
						<span class="<?php echo $f[0] ? 'check' : 'cross'; ?>" aria-hidden="true">
							<?php echo fleetmonitor_icon( $f[0] ? 'check' : 'close' ); // phpcs:ignore ?>
						</span>
						<span><?php echo esc_html( $f[1] ); ?></span>
					</li>
					<?php endforeach; ?>
				</ul>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-white w-full">
					<?php esc_html_e( 'Start Free Trial', 'fleetmonitor' ); ?>
				</a>
			</div>

			<!-- Enterprise Plan -->
			<div class="pricing-card" role="listitem">
				<h3 class="pricing-plan-name"><?php esc_html_e( 'Enterprise', 'fleetmonitor' ); ?></h3>
				<p class="pricing-plan-description"><?php esc_html_e( 'Custom solution for large fleets with dedicated support and integrations.', 'fleetmonitor' ); ?></p>
				<div class="pricing-price">
					<div class="pricing-amount">
						<span style="font-size:1.5rem; font-weight:700;"><?php esc_html_e( 'Custom', 'fleetmonitor' ); ?></span>
					</div>
					<div class="pricing-period"><?php esc_html_e( 'tailored to your needs', 'fleetmonitor' ); ?></div>
				</div>
				<div class="pricing-vehicles"><?php esc_html_e( 'Unlimited vehicles', 'fleetmonitor' ); ?></div>
				<div class="pricing-divider"></div>
				<ul class="pricing-features" aria-label="<?php esc_attr_e( 'Enterprise plan features', 'fleetmonitor' ); ?>">
					<?php
					$enterprise_features = array(
						array( true, __( 'Everything in Professional', 'fleetmonitor' ) ),
						array( true, __( 'Dedicated account manager', 'fleetmonitor' ) ),
						array( true, __( 'Custom API integrations', 'fleetmonitor' ) ),
						array( true, __( 'White-label option', 'fleetmonitor' ) ),
						array( true, __( 'On-premise deployment', 'fleetmonitor' ) ),
						array( true, __( 'SLA 99.99% uptime', 'fleetmonitor' ) ),
						array( true, __( 'Custom training & onboarding', 'fleetmonitor' ) ),
					);
					foreach ( $enterprise_features as $f ) :
					?>
					<li class="pricing-feature">
						<span class="check" aria-hidden="true">
							<?php echo fleetmonitor_icon( 'check' ); // phpcs:ignore ?>
						</span>
						<span><?php echo esc_html( $f[1] ); ?></span>
					</li>
					<?php endforeach; ?>
				</ul>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary w-full">
					<?php esc_html_e( 'Contact Sales', 'fleetmonitor' ); ?>
				</a>
			</div>

		</div><!-- .pricing-grid -->
	</div><!-- .container -->
</section><!-- .pricing-section -->

<!-- =====================================================
     TESTIMONIALS SECTION
     ===================================================== -->
<section class="section testimonials-section" id="testimonials" aria-labelledby="testimonials-title">
	<div class="container">
		<header class="section-header text-center">
			<div class="badge badge-accent"><?php esc_html_e( 'Customer Stories', 'fleetmonitor' ); ?></div>
			<h2 class="section-title" id="testimonials-title">
				<?php esc_html_e( 'Trusted by Fleet Managers Worldwide', 'fleetmonitor' ); ?>
			</h2>
			<p class="section-subtitle">
				<?php esc_html_e( 'Read what our customers say about how FleetMonitor transformed their operations.', 'fleetmonitor' ); ?>
			</p>
		</header>

		<?php
		// Try to get testimonials from CPT first
		$testimonials_query = new WP_Query(
			array(
				'post_type'      => 'fm_testimonial',
				'posts_per_page' => 3,
				'orderby'        => 'rand',
			)
		);

		// Fall back to hardcoded testimonials
		$testimonials = array(
			array(
				'text'    => __( '"FleetMonitor cut our fuel costs by 31% in the first quarter. The real-time alerts and driver behaviour reports are simply indispensable. Our drivers drive safer and our customers are happier."', 'fleetmonitor' ),
				'name'    => 'Adam Kowalski',
				'role'    => __( 'Fleet Director, Kowalski Transport Sp. z o.o.', 'fleetmonitor' ),
				'initial' => 'AK',
				'stars'   => 5,
			),
			array(
				'text'    => __( '"We manage 120 vehicles across 3 countries and FleetMonitor gives us a single pane of glass. Setup was incredibly easy and the support team is exceptional."', 'fleetmonitor' ),
				'name'    => 'Maria Nowak',
				'role'    => __( 'Operations Manager, EuroLogistics GmbH', 'fleetmonitor' ),
				'initial' => 'MN',
				'stars'   => 5,
			),
			array(
				'text'    => __( '"The WooCommerce store made it super easy to order replacement GPS units. Combined with the SaaS platform, everything is in one place. Highly recommend!"', 'fleetmonitor' ),
				'name'    => 'Piotr Wiśniewski',
				'role'    => __( 'Head of IT, City Delivery Services', 'fleetmonitor' ),
				'initial' => 'PW',
				'stars'   => 5,
			),
		);
		?>

		<div class="testimonials-grid" role="list">
			<?php if ( $testimonials_query->have_posts() ) : ?>
				<?php while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post(); ?>
				<div class="testimonial-card" role="listitem">
					<div class="testimonial-quote-icon" aria-hidden="true">&ldquo;</div>
					<div class="testimonial-rating" aria-label="<?php esc_attr_e( '5 stars', 'fleetmonitor' ); ?>">
						<?php echo str_repeat( '★', 5 ); // phpcs:ignore ?>
					</div>
					<p class="testimonial-text">&ldquo;<?php echo wp_kses_post( get_the_content() ); ?>&rdquo;</p>
					<div class="testimonial-author">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="testimonial-avatar" style="background:none; overflow:hidden;">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</div>
						<?php else : ?>
							<div class="testimonial-avatar" aria-hidden="true">
								<?php echo esc_html( mb_substr( get_the_title(), 0, 2 ) ); ?>
							</div>
						<?php endif; ?>
						<div class="testimonial-author-info">
							<div class="name"><?php the_title(); ?></div>
							<div class="role"><?php echo esc_html( get_post_meta( get_the_ID(), '_testimonial_role', true ) ); ?></div>
						</div>
					</div>
				</div>
				<?php endwhile; wp_reset_postdata(); ?>

			<?php else : ?>
				<?php foreach ( $testimonials as $t ) : ?>
				<div class="testimonial-card" role="listitem">
					<div class="testimonial-quote-icon" aria-hidden="true">&ldquo;</div>
					<div class="testimonial-rating" aria-label="<?php printf( esc_attr__( '%d stars', 'fleetmonitor' ), $t['stars'] ); ?>">
						<?php echo str_repeat( '★', (int) $t['stars'] ); // phpcs:ignore ?>
					</div>
					<p class="testimonial-text"><?php echo esc_html( $t['text'] ); ?></p>
					<div class="testimonial-author">
						<div class="testimonial-avatar" aria-hidden="true">
							<?php echo esc_html( $t['initial'] ); ?>
						</div>
						<div class="testimonial-author-info">
							<div class="name"><?php echo esc_html( $t['name'] ); ?></div>
							<div class="role"><?php echo esc_html( $t['role'] ); ?></div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div><!-- .testimonials-grid -->

	</div><!-- .container -->
</section><!-- .testimonials-section -->

<!-- =====================================================
     LATEST BLOG POSTS
     ===================================================== -->
<?php
$blog_posts = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);
if ( $blog_posts->have_posts() ) :
?>
<section class="section blog-section" id="blog" aria-labelledby="blog-title">
	<div class="container">
		<header class="section-header text-center">
			<div class="badge badge-accent"><?php esc_html_e( 'Knowledge Base', 'fleetmonitor' ); ?></div>
			<h2 class="section-title" id="blog-title">
				<?php esc_html_e( 'Latest from Our Blog', 'fleetmonitor' ); ?>
			</h2>
			<p class="section-subtitle">
				<?php esc_html_e( 'Tips, guides and industry news on GPS tracking, fleet management and vehicle telematics.', 'fleetmonitor' ); ?>
			</p>
		</header>

		<div class="blog-grid" role="list">
			<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
			<article class="blog-card" role="listitem">
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
							$word_count  = str_word_count( wp_strip_all_tags( get_the_content() ) );
							$read_time   = max( 1, ceil( $word_count / 200 ) );
							printf(
								/* translators: %d: read time in minutes */
								esc_html__( '%d min read', 'fleetmonitor' ),
								$read_time
							);
							?>
						</span>
					</div>
					<h3 class="blog-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<p class="blog-excerpt"><?php the_excerpt(); ?></p>
					<a href="<?php the_permalink(); ?>" class="blog-link">
						<?php esc_html_e( 'Read more', 'fleetmonitor' ); ?>
						<?php echo fleetmonitor_icon( 'arrow-right' ); // phpcs:ignore ?>
					</a>
				</div>
			</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div><!-- .blog-grid -->

		<div class="text-center" style="margin-top: 3rem;">
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="btn btn-secondary btn-lg">
				<?php esc_html_e( 'View All Articles', 'fleetmonitor' ); ?>
			</a>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- =====================================================
     CTA SECTION
     ===================================================== -->
<section class="cta-section" aria-labelledby="cta-title">
	<div class="container">
		<div class="cta-content">
			<h2 class="cta-title" id="cta-title">
				<?php esc_html_e( 'Ready to Optimise Your Fleet?', 'fleetmonitor' ); ?>
			</h2>
			<p class="cta-description">
				<?php esc_html_e( 'Join 2,500+ companies already saving time and money with FleetMonitor. Start your 14-day free trial — no credit card required.', 'fleetmonitor' ); ?>
			</p>
			<div class="cta-actions">
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-white btn-lg">
					<?php esc_html_e( 'Start Free Trial', 'fleetmonitor' ); ?>
				</a>
				<a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) : esc_url( home_url( '/shop/' ) ); ?>" class="btn btn-outline-white btn-lg">
					<?php esc_html_e( 'Browse Hardware Store', 'fleetmonitor' ); ?>
				</a>
			</div>
			<p class="cta-note">
				<?php esc_html_e( '14-day free trial • No credit card required • Cancel anytime', 'fleetmonitor' ); ?>
			</p>
		</div>
	</div>
</section>

<?php
get_footer();
