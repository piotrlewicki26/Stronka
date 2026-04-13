<?php
/**
 * Template Name: Driver Behavior
 * Template Post Type: page
 *
 * Dedicated page for driver behavior monitoring / eco-driving features.
 * Based on content from fleetlink.pl/eco-driving/
 *
 * @package FleetLink
 */

get_header();
?>

<!-- =====================================================
     PAGE HERO
     ===================================================== -->
<section class="page-hero" aria-label="<?php esc_attr_e( 'Driver Behavior Monitoring', 'fleetlink' ); ?>">
<div class="container">
<div class="page-hero-eyebrow">
<span class="live-dot" aria-hidden="true"></span>
<?php esc_html_e( 'Monitorowanie Floty · Analityka Jazdy', 'fleetlink' ); ?>
</div>
<h1 class="page-hero-title">
<?php esc_html_e( 'Zachowanie Kierowcy –', 'fleetlink' ); ?><br>
<span class="gradient-text"><?php esc_html_e( 'Monitoring i Analiza', 'fleetlink' ); ?></span>
</h1>
<p class="page-hero-subtitle">
<?php esc_html_e( 'Analizuj styl jazdy każdego kierowcy w czasie rzeczywistym. Redukuj koszty paliwa, zwiększaj bezpieczeństwo i buduj kulturę eco-drivingu w całej flocie.', 'fleetlink' ); ?>
</p>
<div class="hero-actions">
<a href="#scoring" class="btn btn-primary btn-lg">
<?php esc_html_e( 'Zobacz jak to działa', 'fleetlink' ); ?>
<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M5 10h10M11 6l4 4-4 4"/></svg>
</a>
<a href="<?php echo esc_url( home_url( '/rejestracja/' ) ); ?>" class="btn btn-outline-white btn-lg">
<?php esc_html_e( 'Wypróbuj za darmo', 'fleetlink' ); ?>
</a>
</div>
<div class="page-hero-stats">
<div class="page-hero-stat">
<div class="page-hero-stat-value">20%</div>
<div class="page-hero-stat-label"><?php esc_html_e( 'Średnia oszczędność paliwa', 'fleetlink' ); ?></div>
</div>
<div class="page-hero-stat">
<div class="page-hero-stat-value">35%</div>
<div class="page-hero-stat-label"><?php esc_html_e( 'Mniej kolizji i wypadków', 'fleetlink' ); ?></div>
</div>
<div class="page-hero-stat">
<div class="page-hero-stat-value">15%</div>
<div class="page-hero-stat-label"><?php esc_html_e( 'Niższe koszty ubezpieczenia', 'fleetlink' ); ?></div>
</div>
<div class="page-hero-stat">
<div class="page-hero-stat-value">Real-time</div>
<div class="page-hero-stat-label"><?php esc_html_e( 'Dane i alerty na żywo', 'fleetlink' ); ?></div>
</div>
</div>
</div>
</section>

<!-- =====================================================
     INTRO / WHAT IS IT
     ===================================================== -->
<section class="db-intro-section section" id="scoring" aria-label="<?php esc_attr_e( 'Czym jest monitoring zachowania kierowcy', 'fleetlink' ); ?>">
<div class="container">
<div class="db-intro-inner">

<div class="db-intro-text fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Eco-Driving & Safety Scoring', 'fleetlink' ); ?></span>
<h2 class="section-title">
<?php esc_html_e( 'Kompleksowa analiza', 'fleetlink' ); ?>
<span class="gradient-text"><?php esc_html_e( 'stylu jazdy', 'fleetlink' ); ?></span>
</h2>
<p class="section-description">
<?php esc_html_e( 'System FleetLink monitoruje i ocenia zachowanie każdego kierowcy w czasie rzeczywistym. Na podstawie danych z telematyki GPS i czujników pokładowych generujemy szczegółowy profil jazdy – od przyspieszania po styl pokonywania zakrętów.', 'fleetlink' ); ?>
</p>
<ul class="db-check-list">
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Ciągłe monitorowanie 24/7 bez ingerencji w pracę kierowcy', 'fleetlink' ); ?>
</li>
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Ocena punktowa (0–100) dla każdej trasy i okresu rozliczeniowego', 'fleetlink' ); ?>
</li>
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Automatyczne raporty tygodniowe i miesięczne na e-mail', 'fleetlink' ); ?>
</li>
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Rankingi i gamifikacja – motywowanie do poprawy stylu jazdy', 'fleetlink' ); ?>
</li>
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Integracja z modułem paliwa – korelacja stylu jazdy ze zużyciem', 'fleetlink' ); ?>
</li>
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" width="10" height="10"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Powiadomienia SMS/e-mail przy wykryciu niebezpiecznego zdarzenia', 'fleetlink' ); ?>
</li>
</ul>
</div>

<!-- Score Card Visual -->
<div class="db-score-card fade-in fade-in-delay-2" aria-label="<?php esc_attr_e( 'Przykładowa karta oceny kierowcy', 'fleetlink' ); ?>">
<div class="db-score-header">
<span class="db-score-header-title"><?php esc_html_e( 'Karta Kierowcy – Tygodniowa', 'fleetlink' ); ?></span>
<span class="db-score-date">Apr 7 – Apr 13</span>
</div>
<div class="db-score-dial">
<div class="db-score-number">87</div>
<div class="db-score-label"><?php esc_html_e( '/ 100 punktów – Dobry', 'fleetlink' ); ?></div>
</div>
<div class="db-score-bars">
<div class="db-score-bar-row">
<div class="db-score-bar-meta">
<span class="db-score-bar-name"><?php esc_html_e( 'Przyspieszanie', 'fleetlink' ); ?></span>
<span class="db-score-bar-val">92/100</span>
</div>
<div class="db-score-bar-track"><div class="db-score-bar-fill" style="width:92%"></div></div>
</div>
<div class="db-score-bar-row">
<div class="db-score-bar-meta">
<span class="db-score-bar-name"><?php esc_html_e( 'Hamowanie', 'fleetlink' ); ?></span>
<span class="db-score-bar-val">85/100</span>
</div>
<div class="db-score-bar-track"><div class="db-score-bar-fill" style="width:85%"></div></div>
</div>
<div class="db-score-bar-row">
<div class="db-score-bar-meta">
<span class="db-score-bar-name"><?php esc_html_e( 'Prędkość', 'fleetlink' ); ?></span>
<span class="db-score-bar-val">78/100</span>
</div>
<div class="db-score-bar-track"><div class="db-score-bar-fill warning" style="width:78%"></div></div>
</div>
<div class="db-score-bar-row">
<div class="db-score-bar-meta">
<span class="db-score-bar-name"><?php esc_html_e( 'Zakręty', 'fleetlink' ); ?></span>
<span class="db-score-bar-val">94/100</span>
</div>
<div class="db-score-bar-track"><div class="db-score-bar-fill" style="width:94%"></div></div>
</div>
<div class="db-score-bar-row">
<div class="db-score-bar-meta">
<span class="db-score-bar-name"><?php esc_html_e( 'Bieg jałowy', 'fleetlink' ); ?></span>
<span class="db-score-bar-val">88/100</span>
</div>
<div class="db-score-bar-track"><div class="db-score-bar-fill" style="width:88%"></div></div>
</div>
</div>
</div>

</div>
</div>
</section>

<!-- =====================================================
     MONITORED EVENTS
     ===================================================== -->
<section class="db-events-section" id="events" aria-label="<?php esc_attr_e( 'Monitorowane zdarzenia', 'fleetlink' ); ?>">
<div class="container">
<div class="section-header center fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Monitorowane zdarzenia', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Co dokładnie śledzimy?', 'fleetlink' ); ?></h2>
<p class="section-description"><?php esc_html_e( 'Każde zdarzenie jest automatycznie wykrywane, klasyfikowane według wagi i zapisywane z dokładną lokalizacją GPS oraz datą i godziną.', 'fleetlink' ); ?></p>
</div>

<div class="db-events-grid">

<!-- 1 -->
<div class="db-event-card fade-in">
<div class="db-event-icon" style="background:rgba(41,121,255,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#2979ff" stroke-width="1.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
</div>
<div class="db-event-title"><?php esc_html_e( 'Agresywne przyspieszanie', 'fleetlink' ); ?></div>
<p class="db-event-desc"><?php esc_html_e( 'Wykrycie gwałtownego naciśnięcia gazu przekraczającego normę przyspieszenia. Zwiększa zużycie paliwa i prowadzi do szybszego zużycia silnika.', 'fleetlink' ); ?></p>
<div class="db-event-severity">
<span class="db-event-severity-label"><?php esc_html_e( 'Waga:', 'fleetlink' ); ?></span>
<div class="db-event-dots">
<div class="db-event-dot active"></div>
<div class="db-event-dot active warning"></div>
<div class="db-event-dot"></div>
</div>
</div>
</div>

<!-- 2 -->
<div class="db-event-card fade-in fade-in-delay-1">
<div class="db-event-icon" style="background:rgba(239,68,68,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.5"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"/></svg>
</div>
<div class="db-event-title"><?php esc_html_e( 'Gwałtowne hamowanie', 'fleetlink' ); ?></div>
<p class="db-event-desc"><?php esc_html_e( 'Nagłe zatrzymanie pojazdu generuje duże siły przeciążeniowe. Wskazuje na brak przewidywania sytuacji drogowej i podwyższa ryzyko kolizji.', 'fleetlink' ); ?></p>
<div class="db-event-severity">
<span class="db-event-severity-label"><?php esc_html_e( 'Waga:', 'fleetlink' ); ?></span>
<div class="db-event-dots">
<div class="db-event-dot active danger"></div>
<div class="db-event-dot active danger"></div>
<div class="db-event-dot active danger"></div>
</div>
</div>
</div>

<!-- 3 -->
<div class="db-event-card fade-in fade-in-delay-2">
<div class="db-event-icon" style="background:rgba(245,158,11,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
</div>
<div class="db-event-title"><?php esc_html_e( 'Przekroczenie prędkości', 'fleetlink' ); ?></div>
<p class="db-event-desc"><?php esc_html_e( 'Jazda powyżej dopuszczalnego limitu, zarówno ogólnego jak i ustalonego dla danego pojazdu lub strefy. Natychmiastowe powiadomienie dla managera floty.', 'fleetlink' ); ?></p>
<div class="db-event-severity">
<span class="db-event-severity-label"><?php esc_html_e( 'Waga:', 'fleetlink' ); ?></span>
<div class="db-event-dots">
<div class="db-event-dot active danger"></div>
<div class="db-event-dot active danger"></div>
<div class="db-event-dot active danger"></div>
</div>
</div>
</div>

<!-- 4 -->
<div class="db-event-card fade-in">
<div class="db-event-icon" style="background:rgba(124,58,237,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="1.5"><path d="M9 17H7A5 5 0 017 7h2M15 7h2a5 5 0 010 10h-2M8 12h8"/></svg>
</div>
<div class="db-event-title"><?php esc_html_e( 'Ostre skręcanie', 'fleetlink' ); ?></div>
<p class="db-event-desc"><?php esc_html_e( 'Gwałtowna zmiana kierunku jazdy – ryzykowne manewry na zakrętach, rondach i skrzyżowaniach. Zwiększa zużycie opon i ryzyko utraty panowania nad pojazdem.', 'fleetlink' ); ?></p>
<div class="db-event-severity">
<span class="db-event-severity-label"><?php esc_html_e( 'Waga:', 'fleetlink' ); ?></span>
<div class="db-event-dots">
<div class="db-event-dot active"></div>
<div class="db-event-dot active warning"></div>
<div class="db-event-dot"></div>
</div>
</div>
</div>

<!-- 5 -->
<div class="db-event-card fade-in fade-in-delay-1">
<div class="db-event-icon" style="background:rgba(16,185,129,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="1.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
</div>
<div class="db-event-title"><?php esc_html_e( 'Bieg jałowy', 'fleetlink' ); ?></div>
<p class="db-event-desc"><?php esc_html_e( 'Silnik pracujący przy zatrzymanym pojeździe powyżej zdefiniowanego czasu. Bezpośredni koszt paliwa bez przejechania ani jednego kilometra.', 'fleetlink' ); ?></p>
<div class="db-event-severity">
<span class="db-event-severity-label"><?php esc_html_e( 'Waga:', 'fleetlink' ); ?></span>
<div class="db-event-dots">
<div class="db-event-dot active"></div>
<div class="db-event-dot"></div>
<div class="db-event-dot"></div>
</div>
</div>
</div>

<!-- 6 -->
<div class="db-event-card fade-in fade-in-delay-2">
<div class="db-event-icon" style="background:rgba(0,229,255,.1)">
<svg viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="1.5"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
</div>
<div class="db-event-title"><?php esc_html_e( 'Używanie telefonu', 'fleetlink' ); ?></div>
<p class="db-event-desc"><?php esc_html_e( 'Wykrywanie rozproszenia uwagi kierowcy podczas jazdy (dostępne z modułem wideo DMS). Najgroźniejszy czynnik wypadków drogowych.', 'fleetlink' ); ?></p>
<div class="db-event-severity">
<span class="db-event-severity-label"><?php esc_html_e( 'Waga:', 'fleetlink' ); ?></span>
<div class="db-event-dots">
<div class="db-event-dot active danger"></div>
<div class="db-event-dot active danger"></div>
<div class="db-event-dot active danger"></div>
</div>
</div>
</div>

</div><!-- .db-events-grid -->
</div>
</section>

<!-- =====================================================
     HOW IT WORKS
     ===================================================== -->
<section class="db-how-section" id="jak-dziala" aria-label="<?php esc_attr_e( 'Jak działa monitoring', 'fleetlink' ); ?>">
<div class="container">
<div class="section-header center fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Przepływ danych', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Od pojazdu do decyzji w 4 krokach', 'fleetlink' ); ?></h2>
</div>
<div class="db-how-steps">
<div class="db-how-step fade-in">
<div class="db-how-num">1</div>
<div class="db-how-title"><?php esc_html_e( 'Urządzenie GPS', 'fleetlink' ); ?></div>
<p class="db-how-desc"><?php esc_html_e( 'Telematyczny czarny skrzynka montowany w pojeździe rejestruje ruch, przyśpieszenia i parametry OBD z częstotliwością 1 Hz.', 'fleetlink' ); ?></p>
</div>
<div class="db-how-step fade-in fade-in-delay-1">
<div class="db-how-num">2</div>
<div class="db-how-title"><?php esc_html_e( 'Transmisja danych', 'fleetlink' ); ?></div>
<p class="db-how-desc"><?php esc_html_e( 'Dane przesyłane są przez sieć GSM/LTE do chmury FleetLink w czasie rzeczywistym lub podczas postoju przez WiFi.', 'fleetlink' ); ?></p>
</div>
<div class="db-how-step fade-in fade-in-delay-2">
<div class="db-how-num">3</div>
<div class="db-how-title"><?php esc_html_e( 'Analiza AI', 'fleetlink' ); ?></div>
<p class="db-how-desc"><?php esc_html_e( 'Algorytmy uczenia maszynowego klasyfikują zdarzenia, generują oceny i wykrywają wzorce niebezpiecznej jazdy – bez fałszywych alarmów.', 'fleetlink' ); ?></p>
</div>
<div class="db-how-step fade-in fade-in-delay-3">
<div class="db-how-num">4</div>
<div class="db-how-title"><?php esc_html_e( 'Panel & Alerty', 'fleetlink' ); ?></div>
<p class="db-how-desc"><?php esc_html_e( 'Manager floty widzi wyniki w panelu, otrzymuje alerty SMS/e-mail i może natychmiast reagować lub planować szkolenia.', 'fleetlink' ); ?></p>
</div>
</div>
</div>
</section>

<!-- =====================================================
     METRICS / KPIs
     ===================================================== -->
<section class="db-metrics-section" id="metrics" aria-label="<?php esc_attr_e( 'Kluczowe wskaźniki', 'fleetlink' ); ?>">
<div class="container">
<div class="section-header center fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Wyniki klientów FleetLink', 'fleetlink' ); ?></span>
<h2 class="section-title"><?php esc_html_e( 'Realne oszczędności, mierzalne efekty', 'fleetlink' ); ?></h2>
<p class="section-description"><?php esc_html_e( 'Dane oparte na wynikach 2 500+ firm korzystających z modułu zachowania kierowcy FleetLink przez min. 6 miesięcy.', 'fleetlink' ); ?></p>
</div>
<div class="db-metrics-grid">

<div class="db-metric-card fade-in">
<div class="db-metric-icon" style="background:rgba(16,185,129,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="1.5" width="20" height="20"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
</div>
<div class="db-metric-value">-20%</div>
<div class="db-metric-label"><?php esc_html_e( 'Zużycie paliwa', 'fleetlink' ); ?></div>
<p class="db-metric-desc"><?php esc_html_e( 'Redukcja kosztów paliwa dzięki eliminacji agresywnej jazdy i nadmiernego biegu jałowego. Zwrot z inwestycji już po 2–3 miesiącach.', 'fleetlink' ); ?></p>
</div>

<div class="db-metric-card fade-in fade-in-delay-1">
<div class="db-metric-icon" style="background:rgba(239,68,68,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.5" width="20" height="20"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
</div>
<div class="db-metric-value">-35%</div>
<div class="db-metric-label"><?php esc_html_e( 'Wypadki i kolizje', 'fleetlink' ); ?></div>
<p class="db-metric-desc"><?php esc_html_e( 'Mniej incydentów drogowych dzięki monitoringowi prędkości, hamowania i stylu jazdy. Niższe koszty napraw i przestojów.', 'fleetlink' ); ?></p>
</div>

<div class="db-metric-card fade-in fade-in-delay-2">
<div class="db-metric-icon" style="background:rgba(41,121,255,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#2979ff" stroke-width="1.5" width="20" height="20"><path d="M9 17v-6M12 17v-3M15 17v-9"/><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
</div>
<div class="db-metric-value">+40%</div>
<div class="db-metric-label"><?php esc_html_e( 'Zaangażowanie kierowców', 'fleetlink' ); ?></div>
<p class="db-metric-desc"><?php esc_html_e( 'Wzrost motywacji do poprawy stylu jazdy dzięki rankingom, celom i modułowi gamifikacji. Kierowcy widzą swoje wyniki i chcą się poprawiać.', 'fleetlink' ); ?></p>
</div>

<div class="db-metric-card fade-in">
<div class="db-metric-icon" style="background:rgba(245,158,11,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.5" width="20" height="20"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
</div>
<div class="db-metric-value">-15%</div>
<div class="db-metric-label"><?php esc_html_e( 'Składki ubezpieczeniowe', 'fleetlink' ); ?></div>
<p class="db-metric-desc"><?php esc_html_e( 'Klienci z udokumentowanym programem eco-drivingu mogą negocjować niższe składki OC/AC z towarzystwami ubezpieczeniowymi.', 'fleetlink' ); ?></p>
</div>

<div class="db-metric-card fade-in fade-in-delay-1">
<div class="db-metric-icon" style="background:rgba(0,229,255,.1)">
<svg viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="1.5" width="20" height="20"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
</div>
<div class="db-metric-value">-25%</div>
<div class="db-metric-label"><?php esc_html_e( 'Zużycie opon i hamulców', 'fleetlink' ); ?></div>
<p class="db-metric-desc"><?php esc_html_e( 'Eliminacja agresywnego przyspieszania i hamowania znacząco wydłuża żywotność opon, klocków hamulcowych i układu napędowego.', 'fleetlink' ); ?></p>
</div>

<div class="db-metric-card fade-in fade-in-delay-2">
<div class="db-metric-icon" style="background:rgba(124,58,237,.12)">
<svg viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="1.5" width="20" height="20"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v6l4 2"/></svg>
</div>
<div class="db-metric-value">CO2</div>
<div class="db-metric-label"><?php esc_html_e( 'Raportowanie emisji', 'fleetlink' ); ?></div>
<p class="db-metric-desc"><?php esc_html_e( 'Automatyczne raporty emisji CO2 na pojazd i trasę. Spełnij wymogi ESG i pokaż klientom zaangażowanie w ochronę środowiska.', 'fleetlink' ); ?></p>
</div>

</div>
</div>
</section>

<!-- =====================================================
     DRIVER RANKING
     ===================================================== -->
<section class="db-ranking-section" id="ranking" aria-label="<?php esc_attr_e( 'Ranking kierowców', 'fleetlink' ); ?>">
<div class="container">
<div class="db-ranking-inner">

<div class="fade-in">
<span class="section-eyebrow"><?php esc_html_e( 'Gamifikacja', 'fleetlink' ); ?></span>
<h2 class="section-title">
<?php esc_html_e( 'Rankingi, które', 'fleetlink' ); ?>
<span class="gradient-text"><?php esc_html_e( 'motywują do zmiany', 'fleetlink' ); ?></span>
</h2>
<p class="section-description">
<?php esc_html_e( 'FleetLink buduje zdrową rywalizację w zespole. Kierowcy porównują wyniki, dążą do poprawy oceny i sami proszą o wskazówki – zamiast traktować monitoring jak nadzór.', 'fleetlink' ); ?>
</p>
<ul class="db-check-list" style="margin-top: var(--sp-5)">
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Cotygodniowy ranking drużynowy i indywidualny', 'fleetlink' ); ?>
</li>
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Odznaki i nagrody za poprawę stylu jazdy', 'fleetlink' ); ?>
</li>
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Aplikacja mobilna z podglądem wyników dla kierowcy', 'fleetlink' ); ?>
</li>
<li>
<span class="db-check-icon"><svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 5l2.5 2.5L8 3"/></svg></span>
<?php esc_html_e( 'Alerty poprawy – natychmiastowa informacja zwrotna po trasie', 'fleetlink' ); ?>
</li>
</ul>
</div>

<!-- Ranking table -->
<div class="db-ranking-table fade-in fade-in-delay-2" aria-label="<?php esc_attr_e( 'Przykładowy ranking kierowców', 'fleetlink' ); ?>">
<div class="db-ranking-thead">
<div class="db-ranking-th">#</div>
<div class="db-ranking-th"><?php esc_html_e( 'Kierowca', 'fleetlink' ); ?></div>
<div class="db-ranking-th"><?php esc_html_e( 'Wynik', 'fleetlink' ); ?></div>
<div class="db-ranking-th"><?php esc_html_e( 'Trend', 'fleetlink' ); ?></div>
</div>
<?php
$drivers = array(
array( 'pos' => '🥇', 'cls' => 'gold',   'init' => 'TK', 'name' => 'T. Kalinowski', 'score' => '94', 'trend' => '▲ +3', 'trend_cls' => 'up'   ),
array( 'pos' => '🥈', 'cls' => 'silver', 'init' => 'MN', 'name' => 'M. Nowaczyk',   'score' => '91', 'trend' => '▲ +1', 'trend_cls' => 'up'   ),
array( 'pos' => '🥉', 'cls' => 'bronze', 'init' => 'AP', 'name' => 'A. Piasecka',   'score' => '88', 'trend' => '— 0',  'trend_cls' => 'same' ),
array( 'pos' => '4',  'cls' => '',       'init' => 'JW', 'name' => 'J. Wróblewski', 'score' => '85', 'trend' => '▲ +5', 'trend_cls' => 'up'   ),
array( 'pos' => '5',  'cls' => '',       'init' => 'KZ', 'name' => 'K. Zieliński',  'score' => '79', 'trend' => '▼ -2', 'trend_cls' => 'down' ),
array( 'pos' => '6',  'cls' => '',       'init' => 'PL', 'name' => 'P. Lewandowski','score' => '76', 'trend' => '▲ +4', 'trend_cls' => 'up'   ),
);
foreach ( $drivers as $d ) :
?>
<div class="db-ranking-row">
<div class="db-rank-pos <?php echo esc_attr( $d['cls'] ); ?>"><?php echo esc_html( $d['pos'] ); ?></div>
<div class="db-rank-driver">
<div class="db-rank-avatar"><?php echo esc_html( $d['init'] ); ?></div>
<div class="db-rank-name"><?php echo esc_html( $d['name'] ); ?></div>
</div>
<div class="db-rank-score"><?php echo esc_html( $d['score'] ); ?>/100</div>
<div class="db-rank-trend <?php echo esc_attr( $d['trend_cls'] ); ?>"><?php echo esc_html( $d['trend'] ); ?></div>
</div>
<?php endforeach; ?>
</div>

</div>
</div>
</section>

<!-- =====================================================
     INTEGRATIONS
     ===================================================== -->
<section class="stats-section section-sm" aria-label="<?php esc_attr_e( 'Integracje', 'fleetlink' ); ?>">
<div class="container">
<div class="section-header center fade-in" style="margin-bottom:var(--sp-10)">
<span class="section-eyebrow"><?php esc_html_e( 'Działa razem z', 'fleetlink' ); ?></span>
<h2 class="section-title" style="font-size:var(--text-3xl)"><?php esc_html_e( 'Pełna integracja z ekosystemem FleetLink', 'fleetlink' ); ?></h2>
</div>
<div class="stats-grid">
<div class="stat-item fade-in">
<div class="stat-value">GPS</div>
<div class="stat-label"><?php esc_html_e( 'Śledzenie & historia tras', 'fleetlink' ); ?></div>
</div>
<div class="stat-item fade-in fade-in-delay-1">
<div class="stat-value">OBD</div>
<div class="stat-label"><?php esc_html_e( 'Dane z komputera pokładowego', 'fleetlink' ); ?></div>
</div>
<div class="stat-item fade-in fade-in-delay-2">
<div class="stat-value">DMS</div>
<div class="stat-label"><?php esc_html_e( 'Monitoring senności kierowcy', 'fleetlink' ); ?></div>
</div>
<div class="stat-item fade-in fade-in-delay-3">
<div class="stat-value">API</div>
<div class="stat-label"><?php esc_html_e( 'ERP, HR i systemy szkoleń', 'fleetlink' ); ?></div>
</div>
</div>
</div>
</section>

<!-- =====================================================
     CTA
     ===================================================== -->
<section class="cta-section" id="cta-db" aria-label="<?php esc_attr_e( 'Zacznij monitorować kierowców', 'fleetlink' ); ?>">
<div class="container">
<h2 class="cta-title fade-in">
<?php esc_html_e( 'Zacznij monitorować zachowanie', 'fleetlink' ); ?><br>
<span class="gradient-text"><?php esc_html_e( 'kierowców już dziś', 'fleetlink' ); ?></span>
</h2>
<p class="cta-description fade-in fade-in-delay-1">
<?php esc_html_e( 'Moduł zachowania kierowcy jest dostępny w planach Pro i Enterprise. Pierwsze wyniki zobaczysz już po 24 godzinach od instalacji.', 'fleetlink' ); ?>
</p>
<div class="cta-actions fade-in fade-in-delay-2">
<a href="<?php echo esc_url( home_url( '/rejestracja/?plan=pro' ) ); ?>" class="btn btn-primary btn-xl">
<?php esc_html_e( 'Zacznij 14-dniowy test Pro', 'fleetlink' ); ?>
</a>
<a href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>" class="btn btn-outline-white btn-xl">
<?php esc_html_e( 'Umów prezentację', 'fleetlink' ); ?>
</a>
</div>
<p class="cta-note fade-in fade-in-delay-3">
<span>&#10003; <?php esc_html_e( 'Bez karty kredytowej', 'fleetlink' ); ?></span>&nbsp;&nbsp;
<span>&#10003; <?php esc_html_e( 'Instalacja w 1 dzień', 'fleetlink' ); ?></span>&nbsp;&nbsp;
<span>&#10003; <?php esc_html_e( 'Wsparcie po polsku', 'fleetlink' ); ?></span>
</p>
</div>
</section>

<?php get_footer(); ?>
