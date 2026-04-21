<?php
/**
 * Homepage template - FleetLink
 *
 * @package FleetLink
 */
get_header();
?>

<!-- HERO -->
<section class="hero-section" id="hero" aria-label="<?php esc_attr_e( 'Hero', 'fleetlink' ); ?>">
<div class="hero-grid" aria-hidden="true"></div>
<div class="hero-glow-1" aria-hidden="true"></div>
<div class="hero-glow-2" aria-hidden="true"></div>
<div class="hero-glow-3" aria-hidden="true"></div>

<div class="hero-content container">
<div class="hero-inner">

<div class="hero-text fade-in">
<div class="hero-eyebrow">
<span class="live-dot" aria-hidden="true"></span>
<?php esc_html_e( 'Monitoring GPS &middot; Zarządzanie Flotą', 'fleetlink' ); ?>
</div>
<h1 class="hero-headline">
<?php
$headline = get_theme_mod( 'hero_headline', 'Kontroluj flotę. Optymalizuj koszty.' );
$words    = explode( ' ', $headline );
$last     = array_pop( $words );
echo esc_html( implode( ' ', $words ) ) . ' <span class="highlight">' . esc_html( $last ) . '</span>';
?>
</h1>
<p class="hero-description">
<?php echo esc_html( get_theme_mod( 'hero_description', 'FleetLink to kompleksowa platforma telematyczna dla firm transportowych i logistycznych. Śledzenie GPS w czasie rzeczywistym, analiza stylu jazdy, zarządzanie konserwacją i pełny sklep z urządzeniami GPS.' ) ); ?>
</p>
<div class="hero-actions">
<a href="#pricing" class="btn btn-primary btn-lg">
<?php esc_html_e( 'Wypróbuj za darmo', 'fleetlink' ); ?>
<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M5 10h10M11 6l4 4-4 4"/></svg>
</a>
<a href="<?php echo esc_url( home_url( '/demo/' ) ); ?>" class="btn btn-outline-white btn-lg">
<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><circle cx="10" cy="10" r="8"/><polygon points="8,7 14,10 8,13" fill="currentColor" stroke="none"/></svg>
<?php esc_html_e( 'Obejrzyj demo', 'fleetlink' ); ?>
</a>
</div>
<div class="hero-trust">
<div class="hero-trust-avatars" aria-hidden="true">
<div class="hero-trust-avatar">TK</div>
<div class="hero-trust-avatar">MP</div>
<div class="hero-trust-avatar">JW</div>
<div class="hero-trust-avatar">AR</div>
</div>
<span><?php esc_html_e( 'Dołącz do 2 500+ firm korzystających z FleetLink', 'fleetlink' ); ?></span>
</div>
</div>

<div class="hero-visual" aria-hidden="true">
<div class="hero-dashboard-card fade-in fade-in-delay-2">
<div class="dashboard-header">
<span class="dashboard-title"><?php esc_html_e( 'Podgląd floty – na żywo', 'fleetlink' ); ?></span>
<span class="live-badge"><span class="live-dot"></span> LIVE</span>
</div>
<div class="map-placeholder">
<div class="map-grid"></div>
<div class="map-vehicle-dot dot-1"></div>
<div class="map-vehicle-dot dot-2"></div>
<div class="map-vehicle-dot dot-3"></div>
<div class="map-vehicle-dot dot-4"></div>
</div>
<div class="dashboard-stats">
<div class="dash-stat"><div class="dash-stat-value">47</div><div class="dash-stat-label"><?php esc_html_e( 'Pojazdy', 'fleetlink' ); ?></div></div>
<div class="dash-stat"><div class="dash-stat-value">38</div><div class="dash-stat-label"><?php esc_html_e( 'W ruchu', 'fleetlink' ); ?></div></div>
<div class="dash-stat"><div class="dash-stat-value">99%</div><div class="dash-stat-label"><?php esc_html_e( 'Uptime', 'fleetlink' ); ?></div></div>
</div>
<div class="vehicle-list">
<div class="vehicle-item">
<span class="vehicle-status-dot moving"></span>
<div class="vehicle-info"><div class="vehicle-plate">WA 12345</div><div class="vehicle-desc"><?php esc_html_e( 'Mercedes Sprinter · Warszawa', 'fleetlink' ); ?></div></div>
<span class="vehicle-speed">72 km/h</span>
</div>
<div class="vehicle-item">
<span class="vehicle-status-dot parked"></span>
<div class="vehicle-info"><div class="vehicle-plate">KR 67890</div><div class="vehicle-desc"><?php esc_html_e( 'Ford Transit · Kraków', 'fleetlink' ); ?></div></div>
<span class="vehicle-speed" style="color:var(--accent-orange)"><?php esc_html_e( 'Postój', 'fleetlink' ); ?></span>
</div>
<div class="vehicle-item">
<span class="vehicle-status-dot idle"></span>
<div class="vehicle-info"><div class="vehicle-plate">PO 11223</div><div class="vehicle-desc"><?php esc_html_e( 'Iveco Daily · Poznań', 'fleetlink' ); ?></div></div>
<span class="vehicle-speed">45 km/h</span>
</div>
</div>
</div>
<div class="hero-notif">
<div class="notif-icon">
<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16"><circle cx="10" cy="10" r="8"/><path d="M10 7v3l2 2"/></svg>
</div>
<div class="notif-content">
<div class="notif-title"><?php esc_html_e( 'Przypomnienie serwisowe', 'fleetlink' ); ?></div>
<div class="notif-desc">WA 12345 &middot; <?php esc_html_e( 'za 3 dni', 'fleetlink' ); ?></div>
</div>
</div>
</div>

</div>
</div>
</section>

<?php
/* =========================================================
 * PHOTO SLIDER  – Customizer-driven, 5 slides
 * ========================================================= */
$slider_slides = array();
for ( $si = 1; $si <= 5; $si++ ) {
	$active = get_theme_mod( "slider_{$si}_active", ( $si <= 3 ) );
	if ( ! $active ) {
		continue;
	}
	$slider_slides[] = array(
		'image'       => get_theme_mod( "slider_{$si}_image", '' ),
		'eyebrow'     => get_theme_mod( "slider_{$si}_eyebrow", fleetlink_slider_default( $si, 'eyebrow' ) ),
		'title'       => get_theme_mod( "slider_{$si}_title",   fleetlink_slider_default( $si, 'title' )   ),
		'description' => get_theme_mod( "slider_{$si}_description", fleetlink_slider_default( $si, 'description' ) ),
		'btn_text'    => get_theme_mod( "slider_{$si}_btn_text", fleetlink_slider_default( $si, 'btn_text' ) ),
		'btn_url'     => get_theme_mod( "slider_{$si}_btn_url",  fleetlink_slider_default( $si, 'btn_url' )  ),
		'btn2_text'   => get_theme_mod( "slider_{$si}_btn2_text", '' ),
		'btn2_url'    => get_theme_mod( "slider_{$si}_btn2_url",  '' ),
	);
}

if ( ! empty( $slider_slides ) ) :
	$autoplay  = get_theme_mod( 'slider_autoplay', true )  ? 'true'  : 'false';
	$interval  = (int) get_theme_mod( 'slider_interval', 6000 );
?>
<!-- PHOTO SLIDER -->
<section class="photo-slider-section" id="photo-slider" aria-label="<?php esc_attr_e( 'Galeria rozwiązań', 'fleetlink' ); ?>">
<div id="photoSlider"
     role="region"
     aria-label="<?php esc_attr_e( 'Slajder zdjęciowy', 'fleetlink' ); ?>"
     data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
     data-interval="<?php echo esc_attr( $interval ); ?>">

<?php foreach ( $slider_slides as $idx => $slide ) :
	$has_img = ! empty( $slide['image'] );
	$style   = $has_img ? ' style="background-image:url(\'' . esc_url( $slide['image'] ) . '\')"' : '';
?>
<div class="ps-slide"<?php echo $style; // phpcs:ignore WordPress.Security.EscapeOutput ?> aria-hidden="<?php echo $idx === 0 ? 'false' : 'true'; ?>">
	<div class="ps-slide-overlay"></div>

	<!-- Decorative large icon per slide (hidden when photo is set) -->
	<?php if ( ! $has_img ) : ?>
	<div class="ps-icon-deco" aria-hidden="true"><?php echo fleetlink_slider_deco_icon( $idx ); // phpcs:ignore ?></div>
	<?php endif; ?>

	<div class="container">
		<div class="ps-slide-content">
			<?php if ( ! empty( $slide['eyebrow'] ) ) : ?>
			<div class="ps-eyebrow"><?php echo esc_html( $slide['eyebrow'] ); ?></div>
			<?php endif; ?>

			<?php if ( ! empty( $slide['title'] ) ) : ?>
			<h2 class="ps-title"><?php echo wp_kses( $slide['title'], array( 'span' => array( 'class' => array() ) ) ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $slide['description'] ) ) : ?>
			<p class="ps-description"><?php echo esc_html( $slide['description'] ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $slide['btn_text'] ) || ! empty( $slide['btn2_text'] ) ) : ?>
			<div class="ps-actions">
				<?php if ( ! empty( $slide['btn_text'] ) ) : ?>
				<a href="<?php echo esc_url( $slide['btn_url'] ?: '#' ); ?>" class="btn btn-primary btn-lg">
					<?php echo esc_html( $slide['btn_text'] ); ?>
					<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M5 10h10M11 6l4 4-4 4"/></svg>
				</a>
				<?php endif; ?>
				<?php if ( ! empty( $slide['btn2_text'] ) ) : ?>
				<a href="<?php echo esc_url( $slide['btn2_url'] ?: '#' ); ?>" class="btn btn-outline-white btn-md">
					<?php echo esc_html( $slide['btn2_text'] ); ?>
				</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endforeach; ?>

<!-- Prev / Next buttons -->
<button class="ps-btn-prev" aria-label="<?php esc_attr_e( 'Poprzedni slajd', 'fleetlink' ); ?>">
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path d="M15 18l-6-6 6-6"/></svg>
</button>
<button class="ps-btn-next" aria-label="<?php esc_attr_e( 'Następny slajd', 'fleetlink' ); ?>">
	<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path d="M9 18l6-6-6-6"/></svg>
</button>

<!-- Dot indicators -->
<div class="ps-dots" role="tablist" aria-label="<?php esc_attr_e( 'Nawigacja slajdera', 'fleetlink' ); ?>"></div>

<!-- Slide counter -->
<div class="ps-counter" aria-hidden="true">01 / <?php echo str_pad( count( $slider_slides ), 2, '0', STR_PAD_LEFT ); ?></div>

</div><!-- #photoSlider -->
</section><!-- .photo-slider-section -->
<?php endif; // slider_slides ?>

<!-- CLIENTS -->
<section class="clients-section" aria-label="<?php esc_attr_e( 'Nasi klienci', 'fleetlink' ); ?>">
<div class="container">
<p class="clients-label"><?php esc_html_e( 'Zaufały nam wiodące firmy transportowe i logistyczne', 'fleetlink' ); ?></p>
</div>
<div class="clients-track" aria-hidden="true">
<?php
$clients = array( 'TRANS-LOG GROUP','CARGO EXPRESS','NORDIC FLEET','EUROTRANSPORT','SWIFT DELIVERY','LOGISTIC PRO','FLEET MASTERS','ROUTE KING','DRIVE TECH','SPEEDY LOGISTICS','TRANS-LOG GROUP','CARGO EXPRESS','NORDIC FLEET','EUROTRANSPORT','SWIFT DELIVERY','LOGISTIC PRO','FLEET MASTERS','ROUTE KING','DRIVE TECH','SPEEDY LOGISTICS' );
foreach ( $clients as $c ) echo '<div class="client-logo">' . esc_html( $c ) . '</div>';
?>
</div>
</section>

<!-- FEATURES -->
<section class="features-section section" id="features">
<div class="container">
<div class="section-header fade-in">
<span class="section-eyebrow"><?php echo esc_html( get_theme_mod( 'features_eyebrow', __( 'Możliwości platformy', 'fleetlink' ) ) ); ?></span>
<h2 class="section-title"><?php echo esc_html( get_theme_mod( 'features_title', __( 'Wszystko, czego potrzebuje nowoczesna flota', 'fleetlink' ) ) ); ?></h2>
<p class="section-description"><?php echo esc_html( get_theme_mod( 'features_description', __( 'FleetLink łączy śledzenie GPS, analizę kierowców, zarządzanie serwisem i optymalizację kosztów w jednej intuicyjnej platformie.', 'fleetlink' ) ) ); ?></p>
</div>
<div class="features-grid">

<div class="feature-card fade-in">
<div class="feature-icon-wrap icon-blue">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="9" stroke-dasharray="2 3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg>
</div>
<h3 class="feature-title"><?php esc_html_e( 'Śledzenie GPS w czasie rzeczywistym', 'fleetlink' ); ?></h3>
<p class="feature-description"><?php esc_html_e( 'Monitoruj pozycję każdego pojazdu na interaktywnej mapie. Historia tras, zdarzenia (przekroczenie prędkości, holowanie, silnik on/off) i powiadomienia na żywo.', 'fleetlink' ); ?></p>
<a href="<?php echo esc_url( home_url( '/gps-tracking/' ) ); ?>" class="feature-link"><?php esc_html_e( 'Dowiedz się więcej', 'fleetlink' ); ?> <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
</div>

<div class="feature-card fade-in fade-in-delay-1">
<div class="feature-icon-wrap icon-green">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7"/></svg>
</div>
<h3 class="feature-title"><?php esc_html_e( 'Monitoring stylu jazdy', 'fleetlink' ); ?></h3>
<p class="feature-description"><?php esc_html_e( 'Analizuj eco-driving, gwałtowne hamowanie, przyspieszanie i przekraczanie prędkości. Obniżaj koszty paliwa nawet o 20% dzięki raportom wydajności kierowców.', 'fleetlink' ); ?></p>
<a href="<?php echo esc_url( home_url( '/monitoring-kierowcow/' ) ); ?>" class="feature-link"><?php esc_html_e( 'Dowiedz się więcej', 'fleetlink' ); ?> <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
</div>

<div class="feature-card fade-in fade-in-delay-2">
<div class="feature-icon-wrap icon-purple">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="6" width="18" height="13" rx="2"/><path d="M3 11h18M8 6V4M16 6V4"/><circle cx="12" cy="15" r="2"/></svg>
</div>
<h3 class="feature-title"><?php esc_html_e( 'Tachografy cyfrowe', 'fleetlink' ); ?></h3>
<p class="feature-description"><?php esc_html_e( 'Automatyczne zdalne pobieranie danych z tachografów. Bądź zgodny z przepisami EU bez ręcznego pobierania – system sam archiwizuje dane.', 'fleetlink' ); ?></p>
<a href="<?php echo esc_url( home_url( '/tachografy/' ) ); ?>" class="feature-link"><?php esc_html_e( 'Dowiedz się więcej', 'fleetlink' ); ?> <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
</div>

<div class="feature-card fade-in fade-in-delay-1">
<div class="feature-icon-wrap icon-orange">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3-3a6 6 0 01-7.4 7.4l-6.3 6.3a2.1 2.1 0 01-3-3L10.3 9a6 6 0 017.4-7.4l-3 3z"/></svg>
</div>
<h3 class="feature-title"><?php esc_html_e( 'Zarządzanie serwisem', 'fleetlink' ); ?></h3>
<p class="feature-description"><?php esc_html_e( 'Automatyczne przypomnienia o przeglądach, rejestracjach i serwisowaniu. Planuj konserwację proaktywnie, unikaj kosztownych awarii i przestojów.', 'fleetlink' ); ?></p>
<a href="<?php echo esc_url( home_url( '/serwis/' ) ); ?>" class="feature-link"><?php esc_html_e( 'Dowiedz się więcej', 'fleetlink' ); ?> <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
</div>

<div class="feature-card fade-in fade-in-delay-2">
<div class="feature-icon-wrap icon-cyan">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
</div>
<h3 class="feature-title"><?php esc_html_e( 'Optymalizacja kosztów i paliwa', 'fleetlink' ); ?></h3>
<p class="feature-description"><?php esc_html_e( 'Szczegółowe raporty zużycia paliwa, optymalizacja tras i analiza kosztów. Redukuj emisję CO2 i obniżaj koszty operacyjne całej floty.', 'fleetlink' ); ?></p>
<a href="<?php echo esc_url( home_url( '/optymalizacja-kosztow/' ) ); ?>" class="feature-link"><?php esc_html_e( 'Dowiedz się więcej', 'fleetlink' ); ?> <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
</div>

<div class="feature-card fade-in fade-in-delay-3">
<div class="feature-icon-wrap icon-red">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="6" width="15" height="12" rx="2"/><polygon points="22,7 17,10 17,14 22,17"/><circle cx="9" cy="12" r="2.5"/></svg>
</div>
<h3 class="feature-title"><?php esc_html_e( 'Telematyka wideo', 'fleetlink' ); ?></h3>
<p class="feature-description"><?php esc_html_e( 'Integracja kamer z systemem GPS. Nagrania na żądanie, automatyczne wyzwalanie przy zdarzeniach i pełna dokumentacja dla ubezpieczycieli.', 'fleetlink' ); ?></p>
<a href="<?php echo esc_url( home_url( '/telematyka-wideo/' ) ); ?>" class="feature-link"><?php esc_html_e( 'Dowiedz się więcej', 'fleetlink' ); ?> <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
</div>

</div>
</div>
</section>

<!-- STATS -->
<section class="stats-section section-sm">
<div class="container">
<div class="stats-grid">
<div class="stat-item fade-in"><div class="stat-value">50 000+</div><div class="stat-label"><?php esc_html_e( 'Pojazdów monitorowanych', 'fleetlink' ); ?></div></div>
<div class="stat-item fade-in fade-in-delay-1"><div class="stat-value">2 500+</div><div class="stat-label"><?php esc_html_e( 'Klientów biznesowych', 'fleetlink' ); ?></div></div>
<div class="stat-item fade-in fade-in-delay-2"><div class="stat-value">99,9%</div><div class="stat-label"><?php esc_html_e( 'Dostępność SLA', 'fleetlink' ); ?></div></div>
<div class="stat-item fade-in fade-in-delay-3"><div class="stat-value">15+</div><div class="stat-label"><?php esc_html_e( 'Lat doświadczenia', 'fleetlink' ); ?></div></div>
</div>
</div>
</section>

<!-- PLATFORM PREVIEW -->
<section class="platform-section section" id="platform">
<div class="container">
<div class="platform-inner">
<div class="platform-text fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Intuicyjny panel', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Pełna kontrola floty', 'fleetlink' ); ?><br><span class="gradient-text"><?php esc_html_e( 'z dowolnego urządzenia', 'fleetlink' ); ?></span></h2>
<p class="section-description"><?php esc_html_e( 'Panel FleetLink jest dostępny z przeglądarki, smartfona i tabletu. Zarządzaj flotą 24/7 z pełnym dostępem do danych historycznych i raportów.', 'fleetlink' ); ?></p>
<div class="platform-features">
<div class="platform-feature-item">
<div class="platform-feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
<div class="platform-feature-text"><div class="platform-feature-title"><?php esc_html_e( 'Raporty automatyczne', 'fleetlink' ); ?></div><div class="platform-feature-desc"><?php esc_html_e( 'Dzienne, tygodniowe i miesięczne raporty dostarczane na e-mail', 'fleetlink' ); ?></div></div>
</div>
<div class="platform-feature-item">
<div class="platform-feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></div>
<div class="platform-feature-text"><div class="platform-feature-title"><?php esc_html_e( 'Alerty i powiadomienia', 'fleetlink' ); ?></div><div class="platform-feature-desc"><?php esc_html_e( 'SMS i e-mail przy przekroczeniu prędkości, geofencing i awariach', 'fleetlink' ); ?></div></div>
</div>
<div class="platform-feature-item">
<div class="platform-feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg></div>
<div class="platform-feature-text"><div class="platform-feature-title"><?php esc_html_e( 'Integracje API', 'fleetlink' ); ?></div><div class="platform-feature-desc"><?php esc_html_e( 'Połącz z ERP, WMS i TMS przez REST API', 'fleetlink' ); ?></div></div>
</div>
</div>
</div>
<div class="platform-mockup fade-in fade-in-delay-2">
<div class="mockup-titlebar">
<div class="mockup-dot"></div><div class="mockup-dot"></div><div class="mockup-dot"></div>
<div class="mockup-url">app.fleetlink.pl/dashboard</div>
</div>
<div class="mockup-body">
<div class="mockup-stats-row">
<div class="mockup-stat-box"><div class="mockup-stat-num">47</div><div class="mockup-stat-lbl"><?php esc_html_e( 'Pojazdy', 'fleetlink' ); ?></div></div>
<div class="mockup-stat-box"><div class="mockup-stat-num">38</div><div class="mockup-stat-lbl"><?php esc_html_e( 'W ruchu', 'fleetlink' ); ?></div></div>
<div class="mockup-stat-box"><div class="mockup-stat-num">6</div><div class="mockup-stat-lbl"><?php esc_html_e( 'Postój', 'fleetlink' ); ?></div></div>
<div class="mockup-stat-box"><div class="mockup-stat-num">3</div><div class="mockup-stat-lbl"><?php esc_html_e( 'Serwis', 'fleetlink' ); ?></div></div>
</div>
<div class="mockup-map-area"><div class="map-grid"></div><div class="map-vehicle-dot dot-1"></div><div class="map-vehicle-dot dot-2"></div><div class="map-vehicle-dot dot-3"></div></div>
<div class="mockup-table">
<div class="mockup-table-row header">
<div class="mockup-cell"><?php esc_html_e( 'Rejestracja', 'fleetlink' ); ?></div>
<div class="mockup-cell"><?php esc_html_e( 'Kierowca', 'fleetlink' ); ?></div>
<div class="mockup-cell"><?php esc_html_e( 'Prędkość', 'fleetlink' ); ?></div>
<div class="mockup-cell"><?php esc_html_e( 'Status', 'fleetlink' ); ?></div>
</div>
<div class="mockup-table-row"><div class="mockup-cell plate">WA 12345</div><div class="mockup-cell">J. Kowalski</div><div class="mockup-cell">72 km/h</div><div class="mockup-cell"><span class="status-pill moving"><?php esc_html_e( 'Jedzie', 'fleetlink' ); ?></span></div></div>
<div class="mockup-table-row"><div class="mockup-cell plate">KR 67890</div><div class="mockup-cell">A. Nowak</div><div class="mockup-cell">0 km/h</div><div class="mockup-cell"><span class="status-pill parked"><?php esc_html_e( 'Postój', 'fleetlink' ); ?></span></div></div>
<div class="mockup-table-row"><div class="mockup-cell plate">GD 33445</div><div class="mockup-cell">M. Wiśniewska</div><div class="mockup-cell">58 km/h</div><div class="mockup-cell"><span class="status-pill moving"><?php esc_html_e( 'Jedzie', 'fleetlink' ); ?></span></div></div>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- HOW IT WORKS -->
<section class="howitworks-section section" id="jak-dziala">
<div class="container">
<div class="section-header center fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Szybki start', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Uruchom FleetLink w 3 krokach', 'fleetlink' ); ?></h2>
<p class="section-description"><?php esc_html_e( 'Prosta instalacja urządzeń GPS, skonfiguruj panel i zacznij monitorować flotę – bez wiedzy technicznej.', 'fleetlink' ); ?></p>
</div>
<div class="steps-grid">
<div class="step-item fade-in"><div class="step-number">1</div><h3 class="step-title"><?php esc_html_e( 'Zamów urządzenia GPS', 'fleetlink' ); ?></h3><p class="step-description"><?php esc_html_e( 'Wybierz lokalizator GPS lub konektor OBD. Dostarczamy do firmy w 2 dni robocze.', 'fleetlink' ); ?></p></div>
<div class="step-item fade-in fade-in-delay-2"><div class="step-number">2</div><h3 class="step-title"><?php esc_html_e( 'Zainstaluj i aktywuj', 'fleetlink' ); ?></h3><p class="step-description"><?php esc_html_e( 'Montaż samodzielny lub przez technika. Aktywacja konta zajmuje mniej niż 5 minut.', 'fleetlink' ); ?></p></div>
<div class="step-item fade-in fade-in-delay-4"><div class="step-number">3</div><h3 class="step-title"><?php esc_html_e( 'Monitoruj flotę online', 'fleetlink' ); ?></h3><p class="step-description"><?php esc_html_e( 'Zaloguj się do panelu z komputera, tabletu lub smartfona i miej flotę pod kontrolą.', 'fleetlink' ); ?></p></div>
</div>
</div>
</section>

<!-- PRICING -->
<section class="pricing-section section" id="pricing">
<div class="container">
<div class="section-header center fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Cennik', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Prosty, przejrzysty cennik', 'fleetlink' ); ?></h2>
<p class="section-description"><?php esc_html_e( 'Wybierz plan dopasowany do wielkości floty. Upgrade w dowolnym momencie.', 'fleetlink' ); ?></p>
</div>
<div class="pricing-toggle">
<span class="pricing-toggle-label"><?php esc_html_e( 'Miesięcznie', 'fleetlink' ); ?></span>
<div class="toggle-switch" id="billingToggle" role="switch" aria-checked="false" tabindex="0">
<div class="toggle-knob"></div>
</div>
<span class="pricing-toggle-label"><?php esc_html_e( 'Rocznie', 'fleetlink' ); ?> <span class="save-badge"><?php esc_html_e( 'Oszczędzasz 20%', 'fleetlink' ); ?></span></span>
</div>
<div class="pricing-grid">
<!-- START -->
<div class="pricing-card fade-in">
<div class="pricing-plan-name"><?php esc_html_e( 'Start', 'fleetlink' ); ?></div>
<div class="pricing-price"><span class="price-currency">PLN</span><span class="price-amount" data-monthly="29" data-annual="23">29</span><span class="price-period"><?php esc_html_e( '/ poj. / mies.', 'fleetlink' ); ?></span></div>
<p class="price-desc"><?php esc_html_e( 'Idealny dla małych firm z flotą do 10 pojazdów.', 'fleetlink' ); ?></p>
<ul class="pricing-features">
<?php foreach ( array( 'GPS w czasie rzeczywistym', 'Historia tras (90 dni)', 'Podstawowe alerty', 'Aplikacja mobilna', 'Support e-mail' ) as $f ) : ?>
<li class="pricing-feature"><span class="pricing-feature-check"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><path d="M2 5l2.5 2.5L8 3"/></svg></span><span><?php echo esc_html( $f ); ?></span></li>
<?php endforeach; ?>
</ul>
<a href="<?php echo esc_url( home_url( '/rejestracja/?plan=start' ) ); ?>" class="btn btn-ghost btn-md" style="width:100%"><?php esc_html_e( 'Zacznij za darmo', 'fleetlink' ); ?></a>
</div>
<!-- PRO -->
<div class="pricing-card featured fade-in fade-in-delay-1">
<span class="featured-ribbon"><?php esc_html_e( 'Najpopularniejszy', 'fleetlink' ); ?></span>
<div class="pricing-plan-name"><?php esc_html_e( 'Pro', 'fleetlink' ); ?></div>
<div class="pricing-price"><span class="price-currency">PLN</span><span class="price-amount" data-monthly="49" data-annual="39">49</span><span class="price-period"><?php esc_html_e( '/ poj. / mies.', 'fleetlink' ); ?></span></div>
<p class="price-desc"><?php esc_html_e( 'Kompletne rozwiązanie dla rozwijających się firm transportowych.', 'fleetlink' ); ?></p>
<ul class="pricing-features">
<?php foreach ( array( 'Wszystko z planu Start', 'Historia tras (2 lata)', 'Monitoring stylu jazdy', 'Tachografy cyfrowe', 'Zarządzanie serwisem', 'Raporty zaawansowane', 'Geofencing (strefy)', 'Wsparcie telefoniczne' ) as $f ) : ?>
<li class="pricing-feature"><span class="pricing-feature-check"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><path d="M2 5l2.5 2.5L8 3"/></svg></span><span><?php echo esc_html( $f ); ?></span></li>
<?php endforeach; ?>
</ul>
<a href="<?php echo esc_url( home_url( '/rejestracja/?plan=pro' ) ); ?>" class="btn btn-primary btn-md" style="width:100%"><?php esc_html_e( 'Wybierz Pro', 'fleetlink' ); ?></a>
</div>
<!-- ENTERPRISE -->
<div class="pricing-card fade-in fade-in-delay-2">
<div class="pricing-plan-name"><?php esc_html_e( 'Enterprise', 'fleetlink' ); ?></div>
<div class="pricing-price"><span class="price-amount" style="font-size:2rem;-webkit-text-fill-color:var(--text-primary)"><?php esc_html_e( 'Wycena', 'fleetlink' ); ?></span></div>
<p class="price-desc"><?php esc_html_e( 'Dedykowane rozwiązanie dla dużych flotowników z 50+ pojazdami.', 'fleetlink' ); ?></p>
<ul class="pricing-features">
<?php foreach ( array( 'Wszystko z planu Pro', 'Telematyka wideo', 'Własne API + integracje', 'Dedykowany opiekun', 'SLA 99,9% gwarantowane', 'Instalacja przez technika', 'Szkolenie personelu', 'Raportowanie CO2' ) as $f ) : ?>
<li class="pricing-feature"><span class="pricing-feature-check"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><path d="M2 5l2.5 2.5L8 3"/></svg></span><span><?php echo esc_html( $f ); ?></span></li>
<?php endforeach; ?>
</ul>
<a href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>" class="btn btn-secondary btn-md" style="width:100%"><?php esc_html_e( 'Skontaktuj się', 'fleetlink' ); ?></a>
</div>
</div>
</div>
</section>

<!-- PRODUCTS (WooCommerce) -->
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<section class="products-section section" id="sklep">
<div class="container">
<div class="section-header center fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Sklep GPS', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Sprzęt GPS dla Twojej floty', 'fleetlink' ); ?></h2>
<p class="section-description"><?php esc_html_e( 'Profesjonalne lokalizatory GPS, urządzenia OBD, kamery i akcesoria – wszystko z szybką dostawą.', 'fleetlink' ); ?></p>
</div>
<div class="products-grid">
<?php
$products = new WP_Query( array( 'post_type' => 'product', 'posts_per_page' => 4, 'post_status' => 'publish' ) );
if ( $products->have_posts() ) :
while ( $products->have_posts() ) :
$products->the_post(); global $product;
?>
<div class="product-card">
<div class="product-card-img">
<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'fleetlink-card' ); } else { echo '<svg width="70" height="70" viewBox="0 0 24 24" fill="none" stroke="rgba(41,121,255,.35)" stroke-width="1"><circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="9"/></svg>'; } ?>
</div>
<div class="product-card-body">
<h3 class="product-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<div class="product-card-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="btn btn-primary btn-sm" style="width:100%"><?php echo esc_html( $product->add_to_cart_text() ); ?></a>
</div>
</div>
<?php endwhile; wp_reset_postdata();
else : echo '<p style="grid-column:1/-1;text-align:center;color:var(--text-muted)">' . esc_html__( 'Produkty pojawią się po aktywacji WooCommerce.', 'fleetlink' ) . '</p>';
endif; ?>
</div>
<div style="text-align:center;margin-top:var(--sp-10)" class="fade-in">
<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-secondary btn-lg"><?php esc_html_e( 'Zobacz cały sklep', 'fleetlink' ); ?></a>
</div>
</div>
</section>
<?php endif; ?>

<!-- TESTIMONIALS -->
<section class="testimonials-section section" id="opinie">
<div class="container">
<div class="section-header center fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Opinie klientów', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Co mówią nasi klienci?', 'fleetlink' ); ?></h2>
</div>
<div class="testimonials-grid">
<?php
$tq = new WP_Query( array( 'post_type' => 'fl_testimonial', 'posts_per_page' => 3 ) );
if ( $tq->have_posts() ) :
$d = 0; while ( $tq->have_posts() ) : $tq->the_post(); ?>
<div class="testimonial-card fade-in fade-in-delay-<?php echo esc_attr( $d ); ?>">
<span class="testimonial-quote-mark" aria-hidden="true">&ldquo;</span>
<div class="testimonial-stars"><?php for($i=0;$i<5;$i++) echo '<span class="star">★</span>'; ?></div>
<blockquote class="testimonial-text"><?php the_excerpt(); ?></blockquote>
<div class="testimonial-author">
<div class="author-avatar"><?php echo esc_html( strtoupper( substr( get_the_title(), 0, 2 ) ) ); ?></div>
<div><div class="author-name"><?php the_title(); ?></div><div class="author-title"><?php echo esc_html( get_post_meta( get_the_ID(), '_position', true ) ); ?></div></div>
</div>
</div>
<?php $d++; endwhile; wp_reset_postdata();
else :
$st = array(
array( 'FleetLink całkowicie zmienił sposób zarządzania naszą flotą 80 pojazdów. Zaoszczędziliśmy ponad 18% na kosztach paliwa w pierwszym kwartale. Polecam każdemu.', 'Tomasz Kalinowski', 'Dyrektor Logistyki, Trans-Log Group', 'TK' ),
array( 'Automatyczne pobieranie tachografów to game-changer. Oszczędzamy 4 godziny tygodniowo na administracji. Wsparcie techniczne zawsze dostępne.', 'Marta Piasecka', 'Fleet Manager, Cargo Express', 'MP' ),
array( 'Raporty stylu jazdy pozwoliły zmniejszyć liczbę kolizji o 35%. Panel jest intuicyjny – wdrożenie zajęło jeden dzień.', 'Jacek Wróblewski', 'Prezes, Nordic Fleet Solutions', 'JW' ),
);
foreach ( $st as $i => $t ) : ?>
<div class="testimonial-card fade-in fade-in-delay-<?php echo esc_attr( $i ); ?>">
<span class="testimonial-quote-mark" aria-hidden="true">&ldquo;</span>
<div class="testimonial-stars"><?php for($s=0;$s<5;$s++) echo '<span class="star">★</span>'; ?></div>
<blockquote class="testimonial-text"><?php echo esc_html( $t[0] ); ?></blockquote>
<div class="testimonial-author">
<div class="author-avatar"><?php echo esc_html( $t[3] ); ?></div>
<div><div class="author-name"><?php echo esc_html( $t[1] ); ?></div><div class="author-title"><?php echo esc_html( $t[2] ); ?></div></div>
</div>
</div>
<?php endforeach; endif; ?>
</div>
</div>
</section>

<!-- BLOG -->
<section class="blog-section section">
<div class="container">
<div class="section-header fade-in" style="display:flex;justify-content:space-between;align-items:flex-end;max-width:100%">
<div>
<span class="section-eyebrow"><?php esc_html_e( 'Blog', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Wiedza o zarządzaniu flotą', 'fleetlink' ); ?></h2>
</div>
<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="btn btn-secondary btn-md" style="flex-shrink:0"><?php esc_html_e( 'Wszystkie artykuły', 'fleetlink' ); ?></a>
</div>
<div class="blog-grid">
<?php
$bq = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3 ) );
if ( $bq->have_posts() ) :
$d = 0; while ( $bq->have_posts() ) : $bq->the_post(); ?>
<article class="blog-card fade-in fade-in-delay-<?php echo esc_attr( $d ); ?>">
<div class="blog-card-img">
<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'fleetlink-card' ); else echo '<svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="rgba(41,121,255,.3)" stroke-width="1"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>'; ?>
</div>
<div class="blog-card-body">
<div class="blog-card-meta"><span class="blog-card-cat"><?php the_category(', '); ?></span><span class="blog-card-date"><?php the_time( get_option('date_format') ); ?></span></div>
<h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<div class="blog-card-excerpt"><?php the_excerpt(); ?></div>
<a href="<?php the_permalink(); ?>" class="blog-card-link"><?php esc_html_e( 'Czytaj więcej', 'fleetlink' ); ?> <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
</div>
</article>
<?php $d++; endwhile; wp_reset_postdata();
else : echo '<p style="grid-column:1/-1;text-align:center;color:var(--text-muted)">' . esc_html__( 'Artykuły pojawią się po dodaniu wpisów.', 'fleetlink' ) . '</p>';
endif; ?>
</div>
</div>
</section>

<!-- FAQ -->
<section class="faq-section section" id="faq">
<div class="container">
<div class="section-header center fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'FAQ', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Najczęściej zadawane pytania', 'fleetlink' ); ?></h2>
</div>
<div class="faq-list" id="faqList">
<?php
$faqs = array(
array( 'Jak długo trwa instalacja urządzenia GPS?', 'Instalacja standardowego lokalizatora GPS zajmuje od 20 minut (OBD plug & play) do 2 godzin (montaż ukryty). Możesz zainstalować samodzielnie lub skorzystać z usługi naszego technika w całej Polsce.' ),
array( 'Czy mogę monitorować flotę na smartfonie?', 'Tak. Aplikacja mobilna FleetLink dostępna na iOS i Android oferuje pełny podgląd mapy, powiadomienia push, historię tras i raporty.' ),
array( 'Jak działa automatyczne pobieranie tachografów?', 'Urządzenie FleetLink łączy się bezprzewodowo z tachografem, gdy pojazd wjedzie na teren bazy. Dane są automatycznie pobierane i archiwizowane w chmurze.' ),
array( 'Czy FleetLink integruje się z systemami ERP?', 'Tak. Oferujemy REST API oraz gotowe integracje z popularnymi systemami ERP, WMS i TMS. Dokumentacja API dostępna jest w panelu.' ),
array( 'Jaki jest minimalny czas umowy?', 'Plany Start i Pro dostępne bez umowy długoterminowej – płacisz miesięcznie. Plan Enterprise na podstawie indywidualnej umowy.' ),
array( 'Czy dane są przechowywane zgodnie z RODO?', 'Tak. Dane przechowujemy na serwerach w UE. Jesteśmy w pełni zgodni z RODO. Oferujemy podpisanie Umowy Powierzenia Danych (DPA).' ),
);
foreach ( $faqs as $i => $faq ) : ?>
<div class="faq-item">
<div class="faq-question" role="button" aria-expanded="false" tabindex="0">
<span class="faq-question-text"><?php echo esc_html( $faq[0] ); ?></span>
<span class="faq-icon" aria-hidden="true"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" width="12" height="12"><path d="M2 4l4 4 4-4"/></svg></span>
</div>
<div class="faq-answer" role="region"><div class="faq-answer-inner"><?php echo esc_html( $faq[1] ); ?></div></div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<!-- CTA -->
<section class="cta-section" id="cta">
<div class="container">
<h2 class="cta-title fade-in"><?php echo esc_html( get_theme_mod( 'cta_title_line1', __( 'Gotowy na inteligentne', 'fleetlink' ) ) ); ?><br><span class="gradient-text"><?php echo esc_html( get_theme_mod( 'cta_title_line2', __( 'zarządzanie flotą?', 'fleetlink' ) ) ); ?></span></h2>
<p class="cta-description fade-in fade-in-delay-1"><?php echo esc_html( get_theme_mod( 'cta_description', __( 'Dołącz do ponad 2 500 firm, które już optymalizują koszty i poprawiają bezpieczeństwo floty z FleetLink.', 'fleetlink' ) ) ); ?></p>
<div class="cta-actions fade-in fade-in-delay-2">
<?php
$cta_btn1_text = get_theme_mod( 'cta_btn1_text', __( 'Zacznij bezpłatny okres próbny', 'fleetlink' ) );
$cta_btn1_url  = get_theme_mod( 'cta_btn1_url', home_url( '/rejestracja/' ) );
$cta_btn2_text = get_theme_mod( 'cta_btn2_text', __( 'Porozmawiaj z konsultantem', 'fleetlink' ) );
$cta_btn2_url  = get_theme_mod( 'cta_btn2_url', home_url( '/kontakt/' ) );
?>
<a href="<?php echo esc_url( $cta_btn1_url ); ?>" class="btn btn-primary btn-xl"><?php echo esc_html( $cta_btn1_text ); ?></a>
<a href="<?php echo esc_url( $cta_btn2_url ); ?>" class="btn btn-outline-white btn-xl"><?php echo esc_html( $cta_btn2_text ); ?></a>
</div>
<p class="cta-note fade-in fade-in-delay-3">
<span>&#10003; <?php esc_html_e( '14 dni za darmo', 'fleetlink' ); ?></span>&nbsp;&nbsp;
<span>&#10003; <?php esc_html_e( 'Bez karty kredytowej', 'fleetlink' ); ?></span>&nbsp;&nbsp;
<span>&#10003; <?php esc_html_e( 'Rezygnacja w każdej chwili', 'fleetlink' ); ?></span>
</p>
</div>
</section>

<?php get_footer(); ?>
