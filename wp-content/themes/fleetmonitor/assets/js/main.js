/**
 * FleetMonitor Pro – Main JavaScript
 *
 * Handles: sticky header, mobile menu, scroll-to-top, preloader,
 * pricing toggle, contact form AJAX, smooth scroll, counter animation.
 *
 * @package FleetMonitor
 * @version 1.0.0
 */

( function ( $ ) {
	'use strict';

	/* =========================================================
	   UTILITIES
	   ========================================================= */

	const debounce = ( fn, delay = 150 ) => {
		let timer;
		return ( ...args ) => {
			clearTimeout( timer );
			timer = setTimeout( () => fn( ...args ), delay );
		};
	};

	const throttle = ( fn, limit = 100 ) => {
		let inThrottle;
		return ( ...args ) => {
			if ( ! inThrottle ) {
				fn( ...args );
				inThrottle = true;
				setTimeout( () => ( inThrottle = false ), limit );
			}
		};
	};

	/* =========================================================
	   PRELOADER
	   ========================================================= */

	function initPreloader() {
		const preloader = document.getElementById( 'preloader' );
		if ( ! preloader ) return;

		const hidePreloader = () => {
			preloader.classList.add( 'hidden' );
		};

		if ( document.readyState === 'complete' ) {
			setTimeout( hidePreloader, 500 );
		} else {
			window.addEventListener( 'load', () => setTimeout( hidePreloader, 500 ) );
		}
	}

	/* =========================================================
	   STICKY HEADER
	   ========================================================= */

	function initStickyHeader() {
		const header = document.getElementById( 'site-header' );
		if ( ! header ) return;

		const handleScroll = throttle( () => {
			if ( window.scrollY > 80 ) {
				header.classList.remove( 'header-transparent' );
				header.classList.add( 'header-scrolled' );
			} else {
				header.classList.add( 'header-transparent' );
				header.classList.remove( 'header-scrolled' );
			}
		}, 50 );

		window.addEventListener( 'scroll', handleScroll, { passive: true } );
		handleScroll(); // run once on load
	}

	/* =========================================================
	   MOBILE MENU
	   ========================================================= */

	function initMobileMenu() {
		const toggle = document.getElementById( 'menu-toggle' );
		const nav    = document.getElementById( 'primary-navigation' );
		const body   = document.body;

		if ( ! toggle || ! nav ) return;

		toggle.addEventListener( 'click', () => {
			const isOpen = toggle.classList.toggle( 'active' );
			toggle.setAttribute( 'aria-expanded', String( isOpen ) );
			body.classList.toggle( 'mobile-menu-open', isOpen );

			if ( isOpen ) {
				// Trap focus within the menu
				nav.querySelector( 'a' )?.focus();
			}
		} );

		// Close on Escape
		document.addEventListener( 'keydown', ( e ) => {
			if ( e.key === 'Escape' && toggle.classList.contains( 'active' ) ) {
				toggle.classList.remove( 'active' );
				toggle.setAttribute( 'aria-expanded', 'false' );
				body.classList.remove( 'mobile-menu-open' );
				toggle.focus();
			}
		} );

		// Close when clicking outside
		document.addEventListener( 'click', ( e ) => {
			if (
				toggle.classList.contains( 'active' ) &&
				! nav.contains( e.target ) &&
				! toggle.contains( e.target )
			) {
				toggle.classList.remove( 'active' );
				toggle.setAttribute( 'aria-expanded', 'false' );
				body.classList.remove( 'mobile-menu-open' );
			}
		} );

		// Close on link click (for single-page sections)
		nav.querySelectorAll( 'a' ).forEach( ( link ) => {
			link.addEventListener( 'click', () => {
				toggle.classList.remove( 'active' );
				toggle.setAttribute( 'aria-expanded', 'false' );
				body.classList.remove( 'mobile-menu-open' );
			} );
		} );
	}

	/* =========================================================
	   SCROLL TO TOP
	   ========================================================= */

	function initScrollTop() {
		const btn = document.getElementById( 'scroll-top' );
		if ( ! btn ) return;

		window.addEventListener( 'scroll', throttle( () => {
			btn.classList.toggle( 'visible', window.scrollY > 400 );
		}, 100 ), { passive: true } );

		btn.addEventListener( 'click', () => {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );
	}

	/* =========================================================
	   SMOOTH SCROLL FOR ANCHOR LINKS
	   ========================================================= */

	function initSmoothScroll() {
		document.querySelectorAll( 'a[href^="#"]' ).forEach( ( anchor ) => {
			anchor.addEventListener( 'click', ( e ) => {
				const target = document.querySelector( anchor.getAttribute( 'href' ) );
				if ( target ) {
					e.preventDefault();
					const headerHeight = parseInt(
						getComputedStyle( document.documentElement )
							.getPropertyValue( '--header-height' )
					) || 80;
					const top = target.getBoundingClientRect().top + window.scrollY - headerHeight - 16;
					window.scrollTo( { top, behavior: 'smooth' } );
				}
			} );
		} );
	}

	/* =========================================================
	   PRICING BILLING TOGGLE
	   ========================================================= */

	function initPricingToggle() {
		const toggle    = document.getElementById( 'billing-toggle' );
		const lblMonthly = document.getElementById( 'toggle-monthly' );
		const lblAnnual  = document.getElementById( 'toggle-annual' );

		if ( ! toggle ) return;

		let isAnnual = false;

		const updatePrices = () => {
			document.querySelectorAll( '.price-value' ).forEach( ( el ) => {
				const monthly = parseFloat( el.dataset.monthly ) || 0;
				const annual  = parseFloat( el.dataset.annual )  || 0;
				el.textContent = isAnnual ? annual : monthly;
			} );
		};

		toggle.addEventListener( 'click', () => {
			isAnnual = ! isAnnual;
			toggle.setAttribute( 'aria-checked', String( isAnnual ) );
			toggle.classList.toggle( 'active', isAnnual );

			if ( lblMonthly ) lblMonthly.classList.toggle( 'active', ! isAnnual );
			if ( lblAnnual )  lblAnnual.classList.toggle( 'active', isAnnual );

			updatePrices();
		} );
	}

	/* =========================================================
	   COUNTER ANIMATION (Stats Section)
	   ========================================================= */

	function initCounters() {
		const counters = document.querySelectorAll( '.stat-number' );
		if ( ! counters.length ) return;

		const animateCounter = ( el ) => {
			const rawValue = el.textContent.trim();
			const numMatch = rawValue.match( /[\d,]+/ );
			if ( ! numMatch ) return; // Non-numeric stat (e.g. "24/7")

			const cleanNum = parseFloat( numMatch[0].replace( /,/g, '' ) );
			if ( isNaN( cleanNum ) ) return;

			const duration = 2000;
			const start    = performance.now();
			const suffix   = rawValue.replace( numMatch[0], '' );
			const prefix   = rawValue.slice( 0, rawValue.indexOf( numMatch[0] ) );

			const update = ( now ) => {
				const elapsed  = now - start;
				const progress = Math.min( elapsed / duration, 1 );
				const eased    = 1 - Math.pow( 1 - progress, 3 ); // ease-out cubic
				const current  = Math.round( cleanNum * eased );
				el.textContent = prefix + current.toLocaleString() + suffix;

				if ( progress < 1 ) {
					requestAnimationFrame( update );
				}
			};

			requestAnimationFrame( update );
		};

		const observer = new IntersectionObserver(
			( entries ) => {
				entries.forEach( ( entry ) => {
					if ( entry.isIntersecting ) {
						animateCounter( entry.target );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.5 }
		);

		counters.forEach( ( counter ) => observer.observe( counter ) );
	}

	/* =========================================================
	   CONTACT FORM (AJAX)
	   ========================================================= */

	function initContactForm() {
		const form     = document.getElementById( 'contact-form' );
		const response = document.getElementById( 'contact-form-response' );
		const submit   = document.getElementById( 'contact-submit' );

		if ( ! form ) return;

		form.addEventListener( 'submit', async ( e ) => {
			e.preventDefault();

			if ( ! form.checkValidity() ) {
				form.reportValidity();
				return;
			}

			const originalText = submit.textContent;
			submit.disabled    = true;
			submit.textContent = fleetmonitorData?.i18n?.loading || 'Sending…';

			try {
				const formData = new FormData( form );
				formData.append( 'action', 'fleetmonitor_contact' );

				const res  = await fetch( fleetmonitorData.ajaxUrl, {
					method: 'POST',
					body:   formData,
				} );
				const data = await res.json();

				response.style.display = 'flex';

				if ( data.success ) {
					response.className = 'alert alert-success';
					response.textContent = data.data.message;
					form.reset();
				} else {
					response.className = 'alert alert-danger';
					response.textContent = data.data.message;
				}

				response.scrollIntoView( { behavior: 'smooth', block: 'nearest' } );
			} catch ( err ) {
				response.style.display = 'flex';
				response.className = 'alert alert-danger';
				response.textContent = 'An error occurred. Please try again.';
			} finally {
				submit.disabled    = false;
				submit.textContent = originalText;
			}
		} );
	}

	/* =========================================================
	   PRODUCT QUICK VIEW (Placeholder)
	   ========================================================= */

	function initProductQuickView() {
		document.querySelectorAll( '.product-quick-btn' ).forEach( ( btn ) => {
			btn.addEventListener( 'click', ( e ) => {
				e.preventDefault();
				// Placeholder: replace with actual quick-view modal logic
				const card = btn.closest( '.product-card' );
				const name = card?.querySelector( '.product-name' )?.textContent || 'Product';
				console.log( 'Quick view:', name );
			} );
		} );
	}

	/* =========================================================
	   HEADER SEARCH TOGGLE
	   ========================================================= */

	function initHeaderSearch() {
		const searchToggle = document.querySelector( '.header-search-toggle' );
		const searchForm   = document.querySelector( '.header-search-form' );

		if ( ! searchToggle || ! searchForm ) return;

		searchToggle.addEventListener( 'click', () => {
			searchForm.classList.toggle( 'active' );
			if ( searchForm.classList.contains( 'active' ) ) {
				searchForm.querySelector( 'input' )?.focus();
			}
		} );
	}

	/* =========================================================
	   INTERSECTION OBSERVER – FADE IN ANIMATION
	   ========================================================= */

	function initFadeInObserver() {
		const elements = document.querySelectorAll(
			'.feature-card, .pricing-card, .testimonial-card, .blog-card, .product-card'
		);

		if ( ! elements.length || ! window.IntersectionObserver ) return;

		// Add initial hidden state
		elements.forEach( ( el ) => {
			el.style.opacity  = '0';
			el.style.transform = 'translateY(20px)';
			el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
		} );

		const observer = new IntersectionObserver(
			( entries ) => {
				entries.forEach( ( entry, i ) => {
					if ( entry.isIntersecting ) {
						setTimeout( () => {
							entry.target.style.opacity   = '1';
							entry.target.style.transform = 'translateY(0)';
						}, i * 80 );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
		);

		elements.forEach( ( el ) => observer.observe( el ) );
	}

	/* =========================================================
	   WOOCOMMERCE CART NOTICE
	   ========================================================= */

	$( document.body ).on( 'added_to_cart', function ( e, fragments, cart_hash, button ) {
		const $btn = $( button );
		const originalText = $btn.text();

		$btn.text( fleetmonitorData?.i18n?.addedToCart || 'Added!' );
		$btn.addClass( 'added' );

		setTimeout( () => {
			$btn.text( originalText );
			$btn.removeClass( 'added' );
		}, 2000 );
	} );

	/* =========================================================
	   INIT ALL MODULES
	   ========================================================= */

	$( document ).ready( function () {
		initPreloader();
		initStickyHeader();
		initMobileMenu();
		initScrollTop();
		initSmoothScroll();
		initPricingToggle();
		initCounters();
		initContactForm();
		initProductQuickView();
		initHeaderSearch();
		initFadeInObserver();
	} );

} )( jQuery );
