<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0a1f3d">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Preloader -->
<div id="preloader" aria-hidden="true">
	<div class="preloader-inner">
		<div class="preloader-logo">Fleet<span>Monitor</span></div>
		<div class="preloader-bar">
			<div class="preloader-progress"></div>
		</div>
	</div>
</div>

<!-- Skip Link -->
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to main content', 'fleetmonitor' ); ?></a>

<!-- Site Header -->
<header class="site-header header-transparent" id="site-header" role="banner">
	<div class="container">
		<div class="header-inner">

			<!-- Logo -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> – <?php esc_attr_e( 'Home', 'fleetmonitor' ); ?>">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<div class="logo-icon" aria-hidden="true">
						<?php echo fleetmonitor_icon( 'location-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</div>
					<div class="logo-text">
						<span class="logo-name"><?php bloginfo( 'name' ); ?></span>
						<span class="logo-tagline"><?php esc_html_e( 'Fleet &amp; GPS Management', 'fleetmonitor' ); ?></span>
					</div>
				<?php endif; ?>
			</a>

			<!-- Primary Navigation -->
			<nav class="primary-navigation" id="primary-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'fleetmonitor' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'walker'         => new FleetMonitor_Walker_Nav_Menu(),
						'fallback_cb'    => 'fleetmonitor_fallback_menu',
					)
				);
				?>
			</nav>

			<!-- Header Actions -->
			<div class="header-actions">
				<?php echo fleetmonitor_header_cart_icon(); // phpcs:ignore WordPress.Security.EscapeOutput ?>

				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-secondary btn-sm d-none d-md-inline-flex">
						<?php esc_html_e( 'Shop', 'fleetmonitor' ); ?>
					</a>
				<?php endif; ?>

				<a href="#pricing" class="btn btn-primary btn-sm">
					<?php esc_html_e( 'Free Trial', 'fleetmonitor' ); ?>
				</a>

				<!-- Mobile menu toggle -->
				<button class="menu-toggle" id="menu-toggle" aria-controls="primary-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'fleetmonitor' ); ?>">
					<span></span>
					<span></span>
					<span></span>
				</button>
			</div>

		</div><!-- .header-inner -->
	</div><!-- .container -->
</header><!-- .site-header -->

<main id="main-content" class="site-main">
<?php

/**
 * Fallback navigation when no menu is assigned.
 */
function fleetmonitor_fallback_menu() {
	$pages = array(
		array( 'url' => home_url( '/' ),           'label' => __( 'Home', 'fleetmonitor' ) ),
		array( 'url' => home_url( '/services/' ),  'label' => __( 'Services', 'fleetmonitor' ) ),
		array( 'url' => home_url( '/shop/' ),      'label' => __( 'Shop', 'fleetmonitor' ) ),
		array( 'url' => home_url( '/pricing/' ),   'label' => __( 'Pricing', 'fleetmonitor' ) ),
		array( 'url' => home_url( '/blog/' ),      'label' => __( 'Blog', 'fleetmonitor' ) ),
		array( 'url' => home_url( '/contact/' ),   'label' => __( 'Contact', 'fleetmonitor' ) ),
	);

	echo '<ul id="primary-menu">';
	foreach ( $pages as $page ) {
		$active = ( home_url( add_query_arg( array() ) ) === $page['url'] ) ? ' class="current-menu-item"' : '';
		printf(
			'<li%s><a href="%s">%s</a></li>',
			$active,
			esc_url( $page['url'] ),
			esc_html( $page['label'] )
		);
	}
	echo '</ul>';
}
