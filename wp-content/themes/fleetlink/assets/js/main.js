/**
 * FleetLink – Main JavaScript
 *
 * @package FleetLink
 */
( function () {
'use strict';

/* =========================================================
   PRELOADER
   ========================================================= */
window.addEventListener( 'load', function () {
var preloader = document.getElementById( 'preloader' );
if ( preloader ) {
setTimeout( function () {
preloader.classList.add( 'hide' );
}, 600 );
}
} );

/* =========================================================
   STICKY / TRANSPARENT HEADER
   ========================================================= */
var header = document.getElementById( 'site-header' );
if ( header ) {
var onScroll = function () {
if ( window.scrollY > 60 ) {
header.classList.add( 'header-scrolled' );
header.classList.remove( 'header-transparent' );
} else {
header.classList.remove( 'header-scrolled' );
header.classList.add( 'header-transparent' );
}
};
window.addEventListener( 'scroll', onScroll, { passive: true } );
onScroll();
}

/* =========================================================
   MOBILE MENU
   ========================================================= */
var menuToggle = document.getElementById( 'menu-toggle' );
var primaryNav = document.getElementById( 'primary-navigation' );

if ( menuToggle && primaryNav ) {
menuToggle.addEventListener( 'click', function () {
var expanded = this.getAttribute( 'aria-expanded' ) === 'true';
this.setAttribute( 'aria-expanded', String( ! expanded ) );
this.classList.toggle( 'active' );
primaryNav.classList.toggle( 'open' );
document.body.style.overflow = expanded ? '' : 'hidden';
} );

// Close on overlay click
document.addEventListener( 'click', function ( e ) {
if (
primaryNav.classList.contains( 'open' ) &&
! primaryNav.contains( e.target ) &&
! menuToggle.contains( e.target )
) {
menuToggle.setAttribute( 'aria-expanded', 'false' );
menuToggle.classList.remove( 'active' );
primaryNav.classList.remove( 'open' );
document.body.style.overflow = '';
}
} );

// Close on Escape
document.addEventListener( 'keydown', function ( e ) {
if ( e.key === 'Escape' && primaryNav.classList.contains( 'open' ) ) {
menuToggle.setAttribute( 'aria-expanded', 'false' );
menuToggle.classList.remove( 'active' );
primaryNav.classList.remove( 'open' );
document.body.style.overflow = '';
menuToggle.focus();
}
} );
}

/* =========================================================
   MOBILE SUB-MENU / MEGA-MENU ACCORDION
   ========================================================= */
if ( primaryNav ) {
var parentItems = primaryNav.querySelectorAll( '.menu-item-has-children' );
parentItems.forEach( function ( item ) {
var link = item.querySelector( ':scope > a' );
if ( ! link ) return;

link.addEventListener( 'click', function ( e ) {
// Only intercept in mobile (nav.open) or when touching the chevron area
if ( ! primaryNav.classList.contains( 'open' ) ) return;

// If clicking a real URL and this is a desktop-style link, let it go through
var subMenu = item.querySelector( ':scope > .sub-menu, :scope > .mega-dropdown' );
if ( ! subMenu ) return;

e.preventDefault();
var wasOpen = item.classList.contains( 'open' );

// Collapse all siblings at same depth
var siblings = item.parentElement ? item.parentElement.querySelectorAll( ':scope > .menu-item-has-children' ) : [];
siblings.forEach( function ( sib ) {
sib.classList.remove( 'open' );
var sibLink = sib.querySelector( ':scope > a' );
if ( sibLink ) sibLink.setAttribute( 'aria-expanded', 'false' );
} );

if ( ! wasOpen ) {
item.classList.add( 'open' );
link.setAttribute( 'aria-expanded', 'true' );
} else {
item.classList.remove( 'open' );
link.setAttribute( 'aria-expanded', 'false' );
}
} );
} );
}

/* =========================================================
   PRICING TOGGLE (monthly / annual)
   ========================================================= */
var billingToggle = document.getElementById( 'billingToggle' );
if ( billingToggle ) {
var isAnnual = false;

billingToggle.addEventListener( 'click', toggleBilling );
billingToggle.addEventListener( 'keydown', function ( e ) {
if ( e.key === 'Enter' || e.key === ' ' ) {
e.preventDefault();
toggleBilling();
}
} );

function toggleBilling() {
isAnnual = ! isAnnual;
billingToggle.classList.toggle( 'active', isAnnual );
billingToggle.setAttribute( 'aria-checked', String( isAnnual ) );

document.querySelectorAll( '.price-amount[data-monthly]' ).forEach( function ( el ) {
var val = isAnnual ? el.getAttribute( 'data-annual' ) : el.getAttribute( 'data-monthly' );
if ( val ) {
// Animate value change
el.style.transform = 'translateY(-4px)';
el.style.opacity = '0';
setTimeout( function () {
el.textContent = val;
el.style.transform = '';
el.style.opacity = '';
}, 150 );
}
} );
}
}

/* =========================================================
   FAQ ACCORDION
   ========================================================= */
var faqItems = document.querySelectorAll( '.faq-item' );
faqItems.forEach( function ( item ) {
var question = item.querySelector( '.faq-question' );
if ( ! question ) return;

question.addEventListener( 'click', function () {
var wasOpen = item.classList.contains( 'open' );
// Close all
faqItems.forEach( function ( fi ) {
fi.classList.remove( 'open' );
fi.querySelector( '.faq-question' )?.setAttribute( 'aria-expanded', 'false' );
} );
if ( ! wasOpen ) {
item.classList.add( 'open' );
question.setAttribute( 'aria-expanded', 'true' );
}
} );

question.addEventListener( 'keydown', function ( e ) {
if ( e.key === 'Enter' || e.key === ' ' ) {
e.preventDefault();
question.click();
}
} );
} );

/* =========================================================
   FADE-IN ON SCROLL (Intersection Observer)
   ========================================================= */
if ( 'IntersectionObserver' in window ) {
var fadeEls = document.querySelectorAll( '.fade-in' );
var fadeObserver = new IntersectionObserver(
function ( entries ) {
entries.forEach( function ( entry ) {
if ( entry.isIntersecting ) {
entry.target.classList.add( 'visible' );
fadeObserver.unobserve( entry.target );
}
} );
},
{ threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
);
fadeEls.forEach( function ( el ) {
fadeObserver.observe( el );
} );
} else {
// Fallback
document.querySelectorAll( '.fade-in' ).forEach( function ( el ) {
el.classList.add( 'visible' );
} );
}

/* =========================================================
   SCROLL TO TOP
   ========================================================= */
var scrollTopBtn = document.getElementById( 'scroll-top' );
if ( scrollTopBtn ) {
window.addEventListener( 'scroll', function () {
scrollTopBtn.classList.toggle( 'visible', window.scrollY > 400 );
}, { passive: true } );

scrollTopBtn.addEventListener( 'click', function () {
window.scrollTo( { top: 0, behavior: 'smooth' } );
} );
}

/* =========================================================
   SMOOTH SCROLL for anchor links
   ========================================================= */
document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( anchor ) {
anchor.addEventListener( 'click', function ( e ) {
var targetId = this.getAttribute( 'href' );
if ( targetId === '#' ) return;
var target = document.querySelector( targetId );
if ( target ) {
e.preventDefault();
var headerOffset = 80;
var targetTop = target.getBoundingClientRect().top + window.pageYOffset - headerOffset;
window.scrollTo( { top: targetTop, behavior: 'smooth' } );

// Close mobile menu if open
if ( primaryNav && primaryNav.classList.contains( 'open' ) ) {
menuToggle.click();
}
}
} );
} );

/* =========================================================
   CONTACT FORM – AJAX
   ========================================================= */
var contactForm = document.getElementById( 'contact-form' );
if ( contactForm ) {
contactForm.addEventListener( 'submit', function ( e ) {
e.preventDefault();
var form    = this;
var btn     = form.querySelector( '[type="submit"]' );
var notice  = form.querySelector( '.form-notice' );
var origTxt = btn ? btn.textContent : '';

if ( btn ) { btn.disabled = true; btn.textContent = 'Wysyłanie...'; }

var data = new FormData( form );
data.append( 'action', 'fleetlink_contact' );
data.append( 'nonce', fleetlinkData?.nonce || '' );

fetch( fleetlinkData?.ajax_url || '/wp-admin/admin-ajax.php', {
method: 'POST',
body: data,
} )
.then( function ( r ) { return r.json(); } )
.then( function ( res ) {
if ( notice ) {
notice.textContent = res.data?.message || ( res.success ? 'Wiadomość wysłana!' : 'Wystąpił błąd.' );
notice.className = 'form-notice ' + ( res.success ? 'success' : 'error' );
}
if ( res.success ) { form.reset(); }
} )
.catch( function () {
if ( notice ) { notice.textContent = 'Błąd połączenia. Spróbuj ponownie.'; notice.className = 'form-notice error'; }
} )
.finally( function () {
if ( btn ) { btn.disabled = false; btn.textContent = origTxt; }
} );
} );
}

/* =========================================================
   MAP VEHICLE DOTS – subtle idle animation
   ========================================================= */
document.querySelectorAll( '.map-vehicle-dot' ).forEach( function ( dot, i ) {
setInterval( function () {
var x = ( Math.random() * 6 - 3 ).toFixed( 1 );
var y = ( Math.random() * 6 - 3 ).toFixed( 1 );
dot.style.transform = 'translate(' + x + 'px,' + y + 'px)';
}, 2000 + i * 500 );
} );

/* =========================================================
   PHOTO SLIDER
   ========================================================= */
( function () {
var slider     = document.getElementById( 'photoSlider' );
if ( ! slider ) return;

var slides     = slider.querySelectorAll( '.ps-slide' );
var dotsWrap   = slider.querySelector( '.ps-dots' );
var prevBtn    = slider.querySelector( '.ps-btn-prev' );
var nextBtn    = slider.querySelector( '.ps-btn-next' );
var totalSlides = slides.length;
if ( totalSlides < 1 ) return;

var current   = 0;
var autoplay  = slider.getAttribute( 'data-autoplay' ) !== 'false';
var interval  = parseInt( slider.getAttribute( 'data-interval' ) || '5000', 10 );
var timer     = null;
var touchStartX = null;
var isAnimating = false;

// Build dots
var dots = [];
if ( dotsWrap ) {
slides.forEach( function ( _, idx ) {
var dot = document.createElement( 'button' );
dot.className = 'ps-dot' + ( idx === 0 ? ' active' : '' );
dot.setAttribute( 'aria-label', 'Slajd ' + ( idx + 1 ) );
dot.addEventListener( 'click', function () { goTo( idx ); } );
dotsWrap.appendChild( dot );
dots.push( dot );
} );
}

function setSlide( idx ) {
if ( isAnimating ) return;
isAnimating = true;
slides[ current ].classList.remove( 'active' );
slides[ current ].classList.add( 'leaving' );
if ( dots[ current ] ) dots[ current ].classList.remove( 'active' );

current = ( idx + totalSlides ) % totalSlides;
slides[ current ].classList.add( 'active' );
if ( dots[ current ] ) dots[ current ].classList.add( 'active' );

// Remove leaving class after transition
var leaving = slider.querySelector( '.ps-slide.leaving' );
if ( leaving ) {
setTimeout( function () {
leaving.classList.remove( 'leaving' );
isAnimating = false;
}, 700 );
} else {
isAnimating = false;
}

// Update ARIA on buttons
if ( prevBtn ) prevBtn.setAttribute( 'aria-label', 'Poprzedni slajd' );
if ( nextBtn ) nextBtn.setAttribute( 'aria-label', 'Następny slajd' );
}

function goTo( idx ) {
setSlide( idx );
resetTimer();
}

function next() { goTo( current + 1 ); }
function prev() { goTo( current - 1 ); }

// Arrow buttons
if ( prevBtn ) prevBtn.addEventListener( 'click', prev );
if ( nextBtn ) nextBtn.addEventListener( 'click', next );

// Keyboard navigation
slider.setAttribute( 'tabindex', '0' );
slider.addEventListener( 'keydown', function ( e ) {
if ( e.key === 'ArrowLeft'  ) { prev(); e.preventDefault(); }
if ( e.key === 'ArrowRight' ) { next(); e.preventDefault(); }
} );

// Touch/swipe
slider.addEventListener( 'touchstart', function ( e ) {
touchStartX = e.touches[ 0 ].clientX;
}, { passive: true } );
slider.addEventListener( 'touchend', function ( e ) {
if ( touchStartX === null ) return;
var diff = touchStartX - e.changedTouches[ 0 ].clientX;
if ( Math.abs( diff ) > 40 ) {
diff > 0 ? next() : prev();
}
touchStartX = null;
}, { passive: true } );

// Autoplay
function startTimer() {
if ( ! autoplay || totalSlides < 2 ) return;
timer = setInterval( next, interval );
}
function resetTimer() {
clearInterval( timer );
startTimer();
}

slider.addEventListener( 'mouseenter', function () { clearInterval( timer ); } );
slider.addEventListener( 'mouseleave', startTimer );

// Init first slide
slides[ 0 ].classList.add( 'active' );
startTimer();
} )();

} )();
