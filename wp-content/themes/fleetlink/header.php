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
if ( has_nav_menu( 'primary' ) ) {
wp_nav_menu( array(
'theme_location' => 'primary',
'menu_id'        => 'primary-menu',
'container'      => false,
'walker'         => new FleetLink_Walker_Nav_Menu(),
) );
} else {
fleetlink_fallback_mega_menu();
}
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

/**
 * Fallback mega menu rendered when no WP menu is assigned.
 * Mirrors the structure used in the Walker so the same CSS applies.
 */
function fleetlink_fallback_mega_menu() {
?>
<ul id="primary-menu">

<li class="menu-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Strona główna', 'fleetlink' ); ?></a></li>

<!-- USŁUGI – mega menu -->
<li class="menu-item menu-item-has-children mega-menu" id="mega-services">
<a href="<?php echo esc_url( home_url( '/uslugi/' ) ); ?>">
<?php esc_html_e( 'Usługi', 'fleetlink' ); ?>
<svg class="dropdown-indicator" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 10l5 5 5-5z"/></svg>
</a>
<ul class="sub-menu mega-dropdown" role="menu">

<!-- Col 1: Monitoring -->
<li class="mega-col-wrap">
<span class="mega-col-hd"><?php esc_html_e( 'Monitoring GPS', 'fleetlink' ); ?></span>
<ul class="mega-col-list">
<li><a href="<?php echo esc_url( home_url( '/gps-tracking/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="9" stroke-dasharray="2 3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg></span>
<?php esc_html_e( 'Śledzenie GPS', 'fleetlink' ); ?>
</a></li>
<li><a href="<?php echo esc_url( home_url( '/driver-behavior/' ) ); ?>" class="mega-item-featured">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7"/><path d="M17 14l2 2 4-4" stroke-linecap="round"/></svg></span>
<?php esc_html_e( 'Zachowanie Kierowcy', 'fleetlink' ); ?>
<span class="mega-item-badge"><?php esc_html_e( 'Nowe', 'fleetlink' ); ?></span>
</a></li>
<li><a href="<?php echo esc_url( home_url( '/tachografy/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="6" width="18" height="13" rx="2"/><path d="M3 11h18M8 6V4M16 6V4"/><circle cx="12" cy="15" r="2"/></svg></span>
<?php esc_html_e( 'Tachografy cyfrowe', 'fleetlink' ); ?>
</a></li>
<li><a href="<?php echo esc_url( home_url( '/telematyka-wideo/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="6" width="15" height="12" rx="2"/><polygon points="22,7 17,10 17,14 22,17"/></svg></span>
<?php esc_html_e( 'Telematyka wideo', 'fleetlink' ); ?>
</a></li>
</ul>
</li>

<!-- Col 2: Zarządzanie -->
<li class="mega-col-wrap">
<span class="mega-col-hd"><?php esc_html_e( 'Zarządzanie', 'fleetlink' ); ?></span>
<ul class="mega-col-list">
<li><a href="<?php echo esc_url( home_url( '/serwis/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3-3a6 6 0 01-7.4 7.4l-6.3 6.3a2.1 2.1 0 01-3-3L10.3 9a6 6 0 017.4-7.4l-3 3z"/></svg></span>
<?php esc_html_e( 'Serwis pojazdów', 'fleetlink' ); ?>
</a></li>
<li><a href="<?php echo esc_url( home_url( '/optymalizacja-kosztow/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></span>
<?php esc_html_e( 'Paliwo & Koszty', 'fleetlink' ); ?>
</a></li>
<li><a href="<?php echo esc_url( home_url( '/geofencing/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
<?php esc_html_e( 'Geofencing', 'fleetlink' ); ?>
</a></li>
<li><a href="<?php echo esc_url( home_url( '/raporty/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 17v-6M12 17v-3M15 17v-9"/><rect x="3" y="3" width="18" height="18" rx="2"/></svg></span>
<?php esc_html_e( 'Raporty', 'fleetlink' ); ?>
</a></li>
</ul>
</li>

<!-- Col 3: Branże -->
<li class="mega-col-wrap">
<span class="mega-col-hd"><?php esc_html_e( 'Branże', 'fleetlink' ); ?></span>
<ul class="mega-col-list">
<li><a href="<?php echo esc_url( home_url( '/transport/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></span>
<?php esc_html_e( 'Transport & TIR', 'fleetlink' ); ?>
</a></li>
<li><a href="<?php echo esc_url( home_url( '/taxi/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3"/><rect x="9" y="11" width="14" height="10" rx="1"/><circle cx="12" cy="21" r="1"/><circle cx="20" cy="21" r="1"/></svg></span>
<?php esc_html_e( 'Taxi & Ride-hailing', 'fleetlink' ); ?>
</a></li>
<li><a href="<?php echo esc_url( home_url( '/budownictwo/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
<?php esc_html_e( 'Budownictwo', 'fleetlink' ); ?>
</a></li>
<li><a href="<?php echo esc_url( home_url( '/leasing/' ) ); ?>">
<span class="mega-item-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg></span>
<?php esc_html_e( 'Leasing & Wynajem', 'fleetlink' ); ?>
</a></li>
</ul>
</li>

<!-- Col 4: CTA panel -->
<li class="mega-col-wrap mega-cta-col">
<div class="mega-cta-card">
<div class="mega-cta-icon" aria-hidden="true">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28"><circle cx="12" cy="10" r="3"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
</div>
<p class="mega-cta-title"><?php esc_html_e( 'Gotowy na start?', 'fleetlink' ); ?></p>
<p class="mega-cta-desc"><?php esc_html_e( '14 dni za darmo, bez karty kredytowej.', 'fleetlink' ); ?></p>
<a href="<?php echo esc_url( home_url( '/rejestracja/' ) ); ?>" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">
<?php esc_html_e( 'Rozpocznij teraz', 'fleetlink' ); ?>
</a>
<a href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>" class="mega-cta-secondary">
<?php esc_html_e( 'Porozmawiaj z nami', 'fleetlink' ); ?>
</a>
</div>
</li>

</ul><!-- .mega-dropdown -->
</li><!-- mega-services -->

<!-- SKLEP – regular dropdown -->
<li class="menu-item menu-item-has-children" id="nav-sklep">
<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">
<?php esc_html_e( 'Sklep', 'fleetlink' ); ?>
<svg class="dropdown-indicator" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 10l5 5 5-5z"/></svg>
</a>
<ul class="sub-menu" role="menu">
<li><a href="<?php echo esc_url( home_url( '/lokalizatory-gps/' ) ); ?>"><?php esc_html_e( 'Lokalizatory GPS', 'fleetlink' ); ?></a></li>
<li><a href="<?php echo esc_url( home_url( '/urzadzenia-obd/' ) ); ?>"><?php esc_html_e( 'Urządzenia OBD', 'fleetlink' ); ?></a></li>
<li><a href="<?php echo esc_url( home_url( '/kamery-samochodowe/' ) ); ?>"><?php esc_html_e( 'Kamery samochodowe', 'fleetlink' ); ?></a></li>
<li><a href="<?php echo esc_url( home_url( '/akcesoria/' ) ); ?>"><?php esc_html_e( 'Akcesoria', 'fleetlink' ); ?></a></li>
</ul>
</li>

<li class="menu-item"><a href="#pricing"><?php esc_html_e( 'Cennik', 'fleetlink' ); ?></a></li>
<li class="menu-item"><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'fleetlink' ); ?></a></li>
<li class="menu-item"><a href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>"><?php esc_html_e( 'Kontakt', 'fleetlink' ); ?></a></li>

</ul>
<?php
}
