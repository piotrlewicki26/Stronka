<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#06080f">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Preloader -->
<div id="preloader" aria-hidden="true">
<div class="preloader-inner">
<div class="preloader-logo">Fleet<span>Link</span></div>
<div class="preloader-bar"><div class="preloader-progress"></div></div>
</div>
</div>

<!-- Skip Link -->
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Przejdź do treści', 'fleetlink' ); ?></a>

<!-- Site Header -->
<header class="site-header header-transparent" id="site-header" role="banner">
<div class="container">
<div class="header-inner">

<!-- Logo -->
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> – <?php esc_attr_e( 'Strona główna', 'fleetlink' ); ?>">
<?php if ( has_custom_logo() ) : ?>
<?php the_custom_logo(); ?>
<?php else : ?>
<div class="logo-icon" aria-hidden="true">
<svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" width="20" height="20"><circle cx="12" cy="10" r="3"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
</div>
<div class="logo-text">
<span class="logo-name"><?php bloginfo( 'name' ); ?></span>
<span class="logo-tagline"><?php esc_html_e( 'System GPS', 'fleetlink' ); ?></span>
</div>
<?php endif; ?>
</a>

<!-- Primary Navigation -->
<nav class="primary-navigation" id="primary-navigation" aria-label="<?php esc_attr_e( 'Nawigacja główna', 'fleetlink' ); ?>">
<?php
wp_nav_menu( array(
'theme_location' => 'primary',
'menu_id'        => 'primary-menu',
'container'      => false,
'walker'         => new FleetLink_Walker_Nav_Menu(),
'fallback_cb'    => 'fleetlink_fallback_menu',
) );
?>
</nav>

<!-- Header Actions -->
<div class="header-actions">
<?php echo fleetlink_header_cart_icon(); // phpcs:ignore WordPress.Security.EscapeOutput ?>

<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-secondary btn-sm d-none d-md-inline-flex">
<?php esc_html_e( 'Sklep', 'fleetlink' ); ?>
</a>
<?php endif; ?>

<a href="#pricing" class="btn btn-primary btn-sm">
<?php esc_html_e( 'Bezpłatny test', 'fleetlink' ); ?>
</a>

<button class="menu-toggle" id="menu-toggle" aria-controls="primary-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Otwórz menu', 'fleetlink' ); ?>">
<span></span><span></span><span></span>
</button>
</div>

</div>
</div>
</header>

<main id="main-content" class="site-main">
<?php

function fleetlink_fallback_menu() {
$pages = array(
array( 'url' => home_url( '/' ),          'label' => __( 'Strona główna', 'fleetlink' ) ),
array( 'url' => home_url( '/uslugi/' ),   'label' => __( 'Usługi', 'fleetlink' ) ),
array( 'url' => home_url( '/shop/' ),     'label' => __( 'Sklep', 'fleetlink' ) ),
array( 'url' => '#pricing',               'label' => __( 'Cennik', 'fleetlink' ) ),
array( 'url' => home_url( '/blog/' ),     'label' => __( 'Blog', 'fleetlink' ) ),
array( 'url' => home_url( '/kontakt/' ),  'label' => __( 'Kontakt', 'fleetlink' ) ),
);
echo '<ul id="primary-menu">';
foreach ( $pages as $page ) {
$active = ( home_url( add_query_arg( array() ) ) === $page['url'] ) ? ' class="current-menu-item"' : '';
printf( '<li%s><a href="%s">%s</a></li>', $active, esc_url( $page['url'] ), esc_html( $page['label'] ) );
}
echo '</ul>';
}
