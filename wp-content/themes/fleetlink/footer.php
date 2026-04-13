</main>

<footer class="site-footer" id="site-footer" role="contentinfo">
<div class="footer-main">
<div class="container">
<div class="footer-grid">

<!-- Brand -->
<div class="footer-brand">
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
<div class="logo-icon" aria-hidden="true">
<svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" width="20" height="20"><circle cx="12" cy="10" r="3"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
</div>
<div class="logo-text">
<span class="logo-name"><?php bloginfo( 'name' ); ?></span>
<span class="logo-tagline"><?php esc_html_e( 'System GPS', 'fleetlink' ); ?></span>
</div>
</a>
<p class="footer-description">
<?php esc_html_e( 'Profesjonalna platforma GPS do monitorowania pojazdów i zarządzania flotą. Śledzenie w czasie rzeczywistym, analityka i kompletny sklep z urządzeniami GPS.', 'fleetlink' ); ?>
</p>
<div class="footer-contact-info">
<div class="footer-contact-item">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
<a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', get_theme_mod( 'company_phone', '+48222500400' ) ) ); ?>">
<?php echo esc_html( get_theme_mod( 'company_phone', '+48 22 250 04 00' ) ); ?>
</a>
</div>
<div class="footer-contact-item">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
<a href="mailto:<?php echo esc_attr( get_theme_mod( 'company_email', 'kontakt@fleetlink.pl' ) ); ?>">
<?php echo esc_html( get_theme_mod( 'company_email', 'kontakt@fleetlink.pl' ) ); ?>
</a>
</div>
<div class="footer-contact-item">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
<span><?php echo esc_html( get_theme_mod( 'company_address', 'ul. Technologiczna 15, 02-677 Warszawa' ) ); ?></span>
</div>
</div>
<div class="footer-social">
<?php
$socials = array(
'facebook'  => array( 'label' => 'Facebook',   'path' => 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z' ),
'twitter'   => array( 'label' => 'Twitter/X',  'path' => 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z' ),
'linkedin'  => array( 'label' => 'LinkedIn',   'path' => 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z' ),
'youtube'   => array( 'label' => 'YouTube',    'path' => 'M22.54 6.42a2.78 2.78 0 00-1.94-1.95C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.4 19.54C5.12 20 12 20 12 20s6.88 0 8.6-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z' ),
);
foreach ( $socials as $key => $data ) {
$url = get_theme_mod( "social_{$key}", '#' );
printf(
'<a href="%s" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="%s"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16"><path d="%s"/></svg></a>',
esc_url( $url ),
esc_attr( $data['label'] ),
esc_attr( $data['path'] )
);
}
?>
</div>
</div>

<!-- Products -->
<div class="footer-nav-col">
<h4 class="footer-col-title"><?php esc_html_e( 'Produkty', 'fleetlink' ); ?></h4>
<?php
if ( has_nav_menu( 'footer-1' ) ) {
wp_nav_menu( array( 'theme_location' => 'footer-1', 'container' => false, 'menu_class' => 'footer-links', 'depth' => 1 ) );
} else {
echo '<ul class="footer-links">';
foreach ( array(
home_url( '/lokalizatory-gps/' )    => __( 'Lokalizatory GPS', 'fleetlink' ),
home_url( '/urzadzenia-obd/' )       => __( 'Urządzenia OBD', 'fleetlink' ),
home_url( '/kamery-samochodowe/' )   => __( 'Kamery samochodowe', 'fleetlink' ),
home_url( '/subskrypcje/' )          => __( 'Subskrypcje', 'fleetlink' ),
home_url( '/akcesoria/' )            => __( 'Akcesoria', 'fleetlink' ),
'#pricing'                           => __( 'Cennik', 'fleetlink' ),
) as $url => $label ) {
printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
}
echo '</ul>';
}
?>
</div>

<!-- Company -->
<div class="footer-nav-col">
<h4 class="footer-col-title"><?php esc_html_e( 'Firma', 'fleetlink' ); ?></h4>
<?php
if ( has_nav_menu( 'footer-2' ) ) {
wp_nav_menu( array( 'theme_location' => 'footer-2', 'container' => false, 'menu_class' => 'footer-links', 'depth' => 1 ) );
} else {
echo '<ul class="footer-links">';
foreach ( array(
home_url( '/o-nas/' )       => __( 'O nas', 'fleetlink' ),
home_url( '/uslugi/' )      => __( 'Usługi', 'fleetlink' ),
home_url( '/blog/' )        => __( 'Blog', 'fleetlink' ),
home_url( '/kariera/' )     => __( 'Kariera', 'fleetlink' ),
home_url( '/partnerzy/' )   => __( 'Partnerzy', 'fleetlink' ),
home_url( '/press/' )       => __( 'Prasa', 'fleetlink' ),
) as $url => $label ) {
printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
}
echo '</ul>';
}
?>
</div>

<!-- Support -->
<div class="footer-nav-col">
<h4 class="footer-col-title"><?php esc_html_e( 'Wsparcie', 'fleetlink' ); ?></h4>
<?php
if ( has_nav_menu( 'footer-3' ) ) {
wp_nav_menu( array( 'theme_location' => 'footer-3', 'container' => false, 'menu_class' => 'footer-links', 'depth' => 1 ) );
} else {
echo '<ul class="footer-links">';
foreach ( array(
home_url( '/pomoc/' )           => __( 'Centrum pomocy', 'fleetlink' ),
home_url( '/kontakt/' )         => __( 'Kontakt', 'fleetlink' ),
home_url( '/dokumentacja/' )    => __( 'Dokumentacja', 'fleetlink' ),
home_url( '/api/' )             => __( 'API', 'fleetlink' ),
home_url( '/status/' )          => __( 'Status systemu', 'fleetlink' ),
) as $url => $label ) {
printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
}
echo '</ul>';
}
?>
</div>

</div>
</div>
</div>

<!-- Footer Bottom -->
<div class="footer-bottom">
<div class="container">
<div class="footer-bottom-inner">
<p class="footer-copyright">
<?php
printf(
esc_html__( '&copy; %1$s %2$s. Wszelkie prawa zastrzeżone.', 'fleetlink' ),
esc_html( gmdate( 'Y' ) ),
esc_html( get_bloginfo( 'name' ) )
);
?>
</p>
<nav class="footer-legal-links" aria-label="<?php esc_attr_e( 'Linki prawne', 'fleetlink' ); ?>">
<?php
if ( has_nav_menu( 'legal' ) ) {
wp_nav_menu( array( 'theme_location' => 'legal', 'container' => false, 'depth' => 1 ) );
} else {
foreach ( array(
home_url( '/polityka-prywatnosci/' ) => __( 'Polityka prywatności', 'fleetlink' ),
home_url( '/regulamin/' )            => __( 'Regulamin', 'fleetlink' ),
home_url( '/cookies/' )              => __( 'Cookies', 'fleetlink' ),
home_url( '/rodo/' )                 => __( 'RODO', 'fleetlink' ),
) as $url => $label ) {
printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
}
}
?>
</nav>
<div class="footer-payments">
<span class="payment-icon">VISA</span>
<span class="payment-icon">MC</span>
<span class="payment-icon">AMEX</span>
<span class="payment-icon">BLIK</span>
<span class="payment-icon">P24</span>
</div>
</div>
</div>
</div>
</footer>

<button id="scroll-top" aria-label="<?php esc_attr_e( 'Przewiń do góry', 'fleetlink' ); ?>">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="20" height="20"><path d="M18 15l-6-6-6 6"/></svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
