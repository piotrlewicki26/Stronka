<?php
/**
 * FleetLink Theme Functions
 *
 * @package FleetLink
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme version constant
define( 'FLEETLINK_VERSION', '1.0.0' );
define( 'FLEETLINK_DIR', get_template_directory() );
define( 'FLEETLINK_URI', get_template_directory_uri() );

/* =========================================================
   THEME SETUP
   ========================================================= */

if ( ! function_exists( 'fleetlink_setup' ) ) {
	function fleetlink_setup() {
		// Make the theme available for translation
		load_theme_textdomain( 'fleetlink', FLEETLINK_DIR . '/languages' );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'fleetlink-hero', 1920, 800, true );
		add_image_size( 'fleetlink-card', 600, 400, true );
		add_image_size( 'fleetlink-thumb', 300, 200, true );
		add_image_size( 'fleetlink-square', 400, 400, true );

		// Register navigation menus
		register_nav_menus(
			array(
				'primary'   => esc_html__( 'Primary Navigation', 'fleetlink' ),
				'footer-1'  => esc_html__( 'Footer Column 1 – Products', 'fleetlink' ),
				'footer-2'  => esc_html__( 'Footer Column 2 – Company', 'fleetlink' ),
				'footer-3'  => esc_html__( 'Footer Column 3 – Support', 'fleetlink' ),
				'legal'     => esc_html__( 'Legal Links', 'fleetlink' ),
			)
		);

		// Switch default core markup for comment form to output valid HTML5
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		// Custom logo
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 60,
				'width'       => 200,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Custom background
		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'ffffff',
			)
		);

		// Custom header
		add_theme_support(
			'custom-header',
			array(
				'default-image' => '',
				'width'         => 1920,
				'height'        => 800,
				'flex-height'   => true,
				'flex-width'    => true,
			)
		);

		// WooCommerce support
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Gutenberg wide alignment
		add_theme_support( 'align-wide' );

		// Responsive embeds
		add_theme_support( 'responsive-embeds' );

		// Editor styles
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor-style.css' );

		// Block editor color palette
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Primary Navy', 'fleetlink' ),
					'slug'  => 'primary',
					'color' => '#0a1f3d',
				),
				array(
					'name'  => esc_html__( 'Accent Blue', 'fleetlink' ),
					'slug'  => 'accent',
					'color' => '#0e7afe',
				),
				array(
					'name'  => esc_html__( 'Success Green', 'fleetlink' ),
					'slug'  => 'success',
					'color' => '#28a745',
				),
				array(
					'name'  => esc_html__( 'Warning Orange', 'fleetlink' ),
					'slug'  => 'warning',
					'color' => '#f76b1c',
				),
				array(
					'name'  => esc_html__( 'White', 'fleetlink' ),
					'slug'  => 'white',
					'color' => '#ffffff',
				),
				array(
					'name'  => esc_html__( 'Light Gray', 'fleetlink' ),
					'slug'  => 'light',
					'color' => '#f8f9fa',
				),
			)
		);

		// Content width
		if ( ! isset( $content_width ) ) {
			$GLOBALS['content_width'] = 1280;
		}
	}
}
add_action( 'after_setup_theme', 'fleetlink_setup' );

/* =========================================================
   WIDGET AREAS
   ========================================================= */

function fleetlink_widgets_init() {
	// Main sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'fleetlink' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in the blog sidebar.', 'fleetlink' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Shop sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Sidebar', 'fleetlink' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Add widgets here to appear in the WooCommerce shop sidebar.', 'fleetlink' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Footer widgets
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area', 'fleetlink' ),
			'id'            => 'footer-widgets',
			'description'   => esc_html__( 'Add widgets here to appear in the footer.', 'fleetlink' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-col-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'fleetlink_widgets_init' );

/* =========================================================
   ENQUEUE SCRIPTS & STYLES
   ========================================================= */

function fleetlink_enqueue_assets() {
	// Google Fonts (Inter)
	wp_enqueue_style(
		'fleetlink-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Main stylesheet (style.css is the theme stylesheet)
	wp_enqueue_style(
		'fleetlink-style',
		get_stylesheet_uri(),
		array( 'fleetlink-fonts' ),
		FLEETLINK_VERSION
	);

	// Main JS
	wp_enqueue_script(
		'fleetlink-main',
		FLEETLINK_URI . '/assets/js/main.js',
		array( 'jquery' ),
		FLEETLINK_VERSION,
		true
	);

	// Localise script with useful data
	wp_localize_script(
		'fleetlink-main',
		'fleetlinkData',
		array(
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'fleetlink_nonce' ),
			'siteUrl'  => home_url(),
			'cartUrl'  => class_exists( 'WooCommerce' ) ? wc_get_cart_url() : '',
			'i18n'     => array(
				'addedToCart'   => esc_html__( 'Added to cart!', 'fleetlink' ),
				'viewCart'      => esc_html__( 'View Cart', 'fleetlink' ),
				'loading'       => esc_html__( 'Loading…', 'fleetlink' ),
			),
		)
	);

	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fleetlink_enqueue_assets' );

/* =========================================================
   WOOCOMMERCE INTEGRATION
   ========================================================= */

// Remove default WooCommerce styles (we handle them via our CSS)
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// Add WooCommerce body class
function fleetlink_woo_body_class( $classes ) {
	if ( class_exists( 'WooCommerce' ) ) {
		$classes[] = 'woo-enabled';
	}
	return $classes;
}
add_filter( 'body_class', 'fleetlink_woo_body_class' );

// Change number of products per row on shop page
function fleetlink_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'fleetlink_loop_columns' );

// Number of products per page
function fleetlink_products_per_page( $cols ) {
	return 12;
}
add_filter( 'loop_shop_per_page', 'fleetlink_products_per_page', 20 );

// Remove default WooCommerce wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Add custom wrappers
function fleetlink_woo_wrapper_start() {
	echo '<div class="woocommerce-main-content">';
}
add_action( 'woocommerce_before_main_content', 'fleetlink_woo_wrapper_start', 10 );

function fleetlink_woo_wrapper_end() {
	echo '</div>';
}
add_action( 'woocommerce_after_main_content', 'fleetlink_woo_wrapper_end', 10 );

// Remove default sidebar from WooCommerce
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Cart fragments for header cart count
function fleetlink_cart_count_fragment( $fragments ) {
	ob_start();
	$count = WC()->cart->get_cart_contents_count();
	?>
	<span class="header-cart-count <?php echo $count > 0 ? 'has-items' : ''; ?>"
	      data-count="<?php echo esc_attr( $count ); ?>">
		<?php echo esc_html( $count ); ?>
	</span>
	<?php
	$fragments['.header-cart-count'] = ob_get_clean();
	return $fragments;
}
if ( class_exists( 'WooCommerce' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'fleetlink_cart_count_fragment' );
}

/* =========================================================
   CUSTOM POST TYPES (from plugin, exposed to theme)
   ========================================================= */

// Register Fleet Vehicle CPT (also done in plugin, but harmless to declare here as fallback)
function fleetlink_register_post_types() {
	// Vehicle CPT
	register_post_type(
		'fm_vehicle',
		array(
			'labels'        => array(
				'name'               => esc_html_x( 'Vehicles', 'post type general name', 'fleetlink' ),
				'singular_name'      => esc_html_x( 'Vehicle', 'post type singular name', 'fleetlink' ),
				'add_new'            => esc_html__( 'Add New Vehicle', 'fleetlink' ),
				'add_new_item'       => esc_html__( 'Add New Vehicle', 'fleetlink' ),
				'edit_item'          => esc_html__( 'Edit Vehicle', 'fleetlink' ),
				'new_item'           => esc_html__( 'New Vehicle', 'fleetlink' ),
				'view_item'          => esc_html__( 'View Vehicle', 'fleetlink' ),
				'search_items'       => esc_html__( 'Search Vehicles', 'fleetlink' ),
				'not_found'          => esc_html__( 'No vehicles found.', 'fleetlink' ),
				'not_found_in_trash' => esc_html__( 'No vehicles found in Trash.', 'fleetlink' ),
			),
			'public'        => true,
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-car',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ),
			'show_in_rest'  => true,
			'rewrite'       => array( 'slug' => 'vehicles' ),
		)
	);

	// Fleet CPT
	register_post_type(
		'fm_fleet',
		array(
			'labels'        => array(
				'name'          => esc_html_x( 'Fleets', 'post type general name', 'fleetlink' ),
				'singular_name' => esc_html_x( 'Fleet', 'post type singular name', 'fleetlink' ),
				'add_new'       => esc_html__( 'Add New Fleet', 'fleetlink' ),
				'add_new_item'  => esc_html__( 'Add New Fleet', 'fleetlink' ),
				'edit_item'     => esc_html__( 'Edit Fleet', 'fleetlink' ),
			),
			'public'        => true,
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-groups',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'show_in_rest'  => true,
			'rewrite'       => array( 'slug' => 'fleets' ),
		)
	);

	// Testimonial CPT
	register_post_type(
		'fm_testimonial',
		array(
			'labels'        => array(
				'name'          => esc_html_x( 'Testimonials', 'post type general name', 'fleetlink' ),
				'singular_name' => esc_html_x( 'Testimonial', 'post type singular name', 'fleetlink' ),
				'add_new_item'  => esc_html__( 'Add New Testimonial', 'fleetlink' ),
				'edit_item'     => esc_html__( 'Edit Testimonial', 'fleetlink' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'menu_icon'     => 'dashicons-format-quote',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'show_in_rest'  => true,
		)
	);
}
add_action( 'init', 'fleetlink_register_post_types' );

/* =========================================================
   CUSTOM TAXONOMIES
   ========================================================= */

function fleetlink_register_taxonomies() {
	// Vehicle Type taxonomy
	register_taxonomy(
		'vehicle_type',
		'fm_vehicle',
		array(
			'labels'       => array(
				'name'              => esc_html_x( 'Vehicle Types', 'taxonomy general name', 'fleetlink' ),
				'singular_name'     => esc_html_x( 'Vehicle Type', 'taxonomy singular name', 'fleetlink' ),
				'search_items'      => esc_html__( 'Search Vehicle Types', 'fleetlink' ),
				'all_items'         => esc_html__( 'All Vehicle Types', 'fleetlink' ),
				'edit_item'         => esc_html__( 'Edit Vehicle Type', 'fleetlink' ),
				'update_item'       => esc_html__( 'Update Vehicle Type', 'fleetlink' ),
				'add_new_item'      => esc_html__( 'Add New Vehicle Type', 'fleetlink' ),
				'new_item_name'     => esc_html__( 'New Vehicle Type Name', 'fleetlink' ),
				'menu_name'         => esc_html__( 'Vehicle Types', 'fleetlink' ),
			),
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'vehicle-type' ),
		)
	);
}
add_action( 'init', 'fleetlink_register_taxonomies' );

/* =========================================================
   CUSTOMIZER SETTINGS
   ========================================================= */

function fleetlink_customize_register( $wp_customize ) {
	// ---- Hero Section ----
	$wp_customize->add_section(
		'fleetlink_hero',
		array(
			'title'    => esc_html__( 'Hero Section', 'fleetlink' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'hero_headline',
		array(
			'default'           => esc_html__( 'Track Every Vehicle. Manage Every Mile.', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hero_headline',
		array(
			'label'   => esc_html__( 'Hero Headline', 'fleetlink' ),
			'section' => 'fleetlink_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hero_description',
		array(
			'default'           => esc_html__( 'Professional GPS fleet management platform. Real-time tracking, route optimization, driver analytics and full WooCommerce store for GPS hardware.', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'hero_description',
		array(
			'label'   => esc_html__( 'Hero Description', 'fleetlink' ),
			'section' => 'fleetlink_hero',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hero_primary_btn_text',
		array(
			'default'           => esc_html__( 'Start Free Trial', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hero_primary_btn_text',
		array(
			'label'   => esc_html__( 'Primary Button Text', 'fleetlink' ),
			'section' => 'fleetlink_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hero_primary_btn_url',
		array(
			'default'           => '#pricing',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'hero_primary_btn_url',
		array(
			'label'   => esc_html__( 'Primary Button URL', 'fleetlink' ),
			'section' => 'fleetlink_hero',
			'type'    => 'url',
		)
	);

	// ---- Company Info ----
	$wp_customize->add_section(
		'fleetlink_company',
		array(
			'title'    => esc_html__( 'Company Information', 'fleetlink' ),
			'priority' => 35,
		)
	);

	$wp_customize->add_setting(
		'company_phone',
		array(
			'default'           => '+48 22 123 456 789',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'company_phone',
		array(
			'label'   => esc_html__( 'Phone Number', 'fleetlink' ),
			'section' => 'fleetlink_company',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'company_email',
		array(
			'default'           => 'contact@fleetlink.pl',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'company_email',
		array(
			'label'   => esc_html__( 'Email Address', 'fleetlink' ),
			'section' => 'fleetlink_company',
			'type'    => 'email',
		)
	);

	$wp_customize->add_setting(
		'company_address',
		array(
			'default'           => 'ul. Technologiczna 15, 00-001 Warszawa, Poland',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'company_address',
		array(
			'label'   => esc_html__( 'Address', 'fleetlink' ),
			'section' => 'fleetlink_company',
			'type'    => 'textarea',
		)
	);

	// ---- Social Links ----
	$wp_customize->add_section(
		'fleetlink_social',
		array(
			'title'    => esc_html__( 'Social Media Links', 'fleetlink' ),
			'priority' => 40,
		)
	);

	$social_networks = array(
		'facebook'  => esc_html__( 'Facebook URL', 'fleetlink' ),
		'twitter'   => esc_html__( 'Twitter / X URL', 'fleetlink' ),
		'linkedin'  => esc_html__( 'LinkedIn URL', 'fleetlink' ),
		'youtube'   => esc_html__( 'YouTube URL', 'fleetlink' ),
		'instagram' => esc_html__( 'Instagram URL', 'fleetlink' ),
	);

	foreach ( $social_networks as $network => $label ) {
		$wp_customize->add_setting(
			"social_{$network}",
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"social_{$network}",
			array(
				'label'   => $label,
				'section' => 'fleetlink_social',
				'type'    => 'url',
			)
		);
	}

	// ---- Stats Section ----
	$wp_customize->add_section(
		'fleetlink_stats',
		array(
			'title'    => esc_html__( 'Stats Section', 'fleetlink' ),
			'priority' => 45,
		)
	);

	$stats_defaults = array(
		array( 'value' => '50,000+', 'label' => 'Vehicles Tracked' ),
		array( 'value' => '2,500+',  'label' => 'Business Clients' ),
		array( 'value' => '99.9%',   'label' => 'Uptime SLA' ),
		array( 'value' => '24/7',    'label' => 'Expert Support' ),
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		$idx = $i - 1;

		$wp_customize->add_setting(
			"stat_{$i}_value",
			array(
				'default'           => $stats_defaults[ $idx ]['value'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"stat_{$i}_value",
			array(
				'label'   => sprintf( esc_html__( 'Stat %d Value', 'fleetlink' ), $i ),
				'section' => 'fleetlink_stats',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"stat_{$i}_label",
			array(
				'default'           => $stats_defaults[ $idx ]['label'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"stat_{$i}_label",
			array(
				'label'   => sprintf( esc_html__( 'Stat %d Label', 'fleetlink' ), $i ),
				'section' => 'fleetlink_stats',
				'type'    => 'text',
			)
		);
	}

	// ---- Photo Slider ----
	$wp_customize->add_section(
		'fleetlink_slider',
		array(
			'title'    => esc_html__( 'Photo Slider', 'fleetlink' ),
			'priority' => 50,
		)
	);

	// Global slider settings
	$wp_customize->add_setting(
		'slider_autoplay',
		array(
			'default'           => true,
			'sanitize_callback' => 'fleetlink_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'slider_autoplay',
		array(
			'label'   => esc_html__( 'Auto-play slider', 'fleetlink' ),
			'section' => 'fleetlink_slider',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'slider_interval',
		array(
			'default'           => 6000,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'slider_interval',
		array(
			'label'       => esc_html__( 'Auto-play interval (ms)', 'fleetlink' ),
			'description' => esc_html__( 'Time in milliseconds between slides (e.g. 6000 = 6 s).', 'fleetlink' ),
			'section'     => 'fleetlink_slider',
			'type'        => 'number',
			'input_attrs' => array( 'min' => 2000, 'max' => 20000, 'step' => 500 ),
		)
	);

	// Per-slide settings (5 slides)
	for ( $s = 1; $s <= 5; $s++ ) {
		// Active toggle
		$wp_customize->add_setting(
			"slider_{$s}_active",
			array(
				'default'           => ( $s <= 3 ),
				'sanitize_callback' => 'fleetlink_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			"slider_{$s}_active",
			array(
				'label'   => sprintf( esc_html__( 'Enable Slide %d', 'fleetlink' ), $s ),
				'section' => 'fleetlink_slider',
				'type'    => 'checkbox',
			)
		);

		// Background image
		$wp_customize->add_setting(
			"slider_{$s}_image",
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"slider_{$s}_image",
				array(
					'label'   => sprintf( esc_html__( 'Slide %d – Background Photo', 'fleetlink' ), $s ),
					'section' => 'fleetlink_slider',
				)
			)
		);

		// Eyebrow
		$wp_customize->add_setting(
			"slider_{$s}_eyebrow",
			array(
				'default'           => fleetlink_slider_default( $s, 'eyebrow' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"slider_{$s}_eyebrow",
			array(
				'label'   => sprintf( esc_html__( 'Slide %d – Eyebrow / Category', 'fleetlink' ), $s ),
				'section' => 'fleetlink_slider',
				'type'    => 'text',
			)
		);

		// Title
		$wp_customize->add_setting(
			"slider_{$s}_title",
			array(
				'default'           => fleetlink_slider_default( $s, 'title' ),
				'sanitize_callback' => 'wp_kses_post',
			)
		);
		$wp_customize->add_control(
			"slider_{$s}_title",
			array(
				'label'       => sprintf( esc_html__( 'Slide %d – Title (HTML allowed for <span class="highlight">)', 'fleetlink' ), $s ),
				'section'     => 'fleetlink_slider',
				'type'        => 'text',
			)
		);

		// Description
		$wp_customize->add_setting(
			"slider_{$s}_description",
			array(
				'default'           => fleetlink_slider_default( $s, 'description' ),
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);
		$wp_customize->add_control(
			"slider_{$s}_description",
			array(
				'label'   => sprintf( esc_html__( 'Slide %d – Description', 'fleetlink' ), $s ),
				'section' => 'fleetlink_slider',
				'type'    => 'textarea',
			)
		);

		// Button 1
		$wp_customize->add_setting(
			"slider_{$s}_btn_text",
			array(
				'default'           => fleetlink_slider_default( $s, 'btn_text' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"slider_{$s}_btn_text",
			array(
				'label'   => sprintf( esc_html__( 'Slide %d – Button 1 Text', 'fleetlink' ), $s ),
				'section' => 'fleetlink_slider',
				'type'    => 'text',
			)
		);
		$wp_customize->add_setting(
			"slider_{$s}_btn_url",
			array(
				'default'           => fleetlink_slider_default( $s, 'btn_url' ),
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"slider_{$s}_btn_url",
			array(
				'label'   => sprintf( esc_html__( 'Slide %d – Button 1 URL', 'fleetlink' ), $s ),
				'section' => 'fleetlink_slider',
				'type'    => 'url',
			)
		);

		// Button 2 (optional secondary)
		$wp_customize->add_setting(
			"slider_{$s}_btn2_text",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"slider_{$s}_btn2_text",
			array(
				'label'   => sprintf( esc_html__( 'Slide %d – Button 2 Text (optional)', 'fleetlink' ), $s ),
				'section' => 'fleetlink_slider',
				'type'    => 'text',
			)
		);
		$wp_customize->add_setting(
			"slider_{$s}_btn2_url",
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"slider_{$s}_btn2_url",
			array(
				'label'   => sprintf( esc_html__( 'Slide %d – Button 2 URL', 'fleetlink' ), $s ),
				'section' => 'fleetlink_slider',
				'type'    => 'url',
			)
		);
	}

	// ---- CTA Section ----
	$wp_customize->add_section(
		'fleetlink_cta',
		array(
			'title'    => esc_html__( 'CTA Section', 'fleetlink' ),
			'priority' => 55,
		)
	);
	$wp_customize->add_setting(
		'cta_title_line1',
		array(
			'default'           => esc_html__( 'Gotowy na inteligentne', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'cta_title_line1',
		array(
			'label'   => esc_html__( 'CTA Headline – Line 1', 'fleetlink' ),
			'section' => 'fleetlink_cta',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'cta_title_line2',
		array(
			'default'           => esc_html__( 'zarządzanie flotą?', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'cta_title_line2',
		array(
			'label'   => esc_html__( 'CTA Headline – Line 2 (gradient)', 'fleetlink' ),
			'section' => 'fleetlink_cta',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'cta_description',
		array(
			'default'           => esc_html__( 'Dołącz do ponad 2 500 firm, które już optymalizują koszty i poprawiają bezpieczeństwo floty z FleetLink.', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'cta_description',
		array(
			'label'   => esc_html__( 'CTA Description', 'fleetlink' ),
			'section' => 'fleetlink_cta',
			'type'    => 'textarea',
		)
	);
	$wp_customize->add_setting(
		'cta_btn1_text',
		array(
			'default'           => esc_html__( 'Zacznij bezpłatny okres próbny', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'cta_btn1_text',
		array(
			'label'   => esc_html__( 'CTA Button 1 Text', 'fleetlink' ),
			'section' => 'fleetlink_cta',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'cta_btn1_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'cta_btn1_url',
		array(
			'label'   => esc_html__( 'CTA Button 1 URL', 'fleetlink' ),
			'section' => 'fleetlink_cta',
			'type'    => 'url',
		)
	);
	$wp_customize->add_setting(
		'cta_btn2_text',
		array(
			'default'           => esc_html__( 'Porozmawiaj z konsultantem', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'cta_btn2_text',
		array(
			'label'   => esc_html__( 'CTA Button 2 Text', 'fleetlink' ),
			'section' => 'fleetlink_cta',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'cta_btn2_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'cta_btn2_url',
		array(
			'label'   => esc_html__( 'CTA Button 2 URL', 'fleetlink' ),
			'section' => 'fleetlink_cta',
			'type'    => 'url',
		)
	);

	// ---- Features Section ----
	$wp_customize->add_section(
		'fleetlink_features',
		array(
			'title'    => esc_html__( 'Features Section', 'fleetlink' ),
			'priority' => 60,
		)
	);
	$wp_customize->add_setting(
		'features_eyebrow',
		array(
			'default'           => esc_html__( 'Możliwości platformy', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'features_eyebrow',
		array(
			'label'   => esc_html__( 'Features – Eyebrow Text', 'fleetlink' ),
			'section' => 'fleetlink_features',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'features_title',
		array(
			'default'           => esc_html__( 'Wszystko, czego potrzebuje nowoczesna flota', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'features_title',
		array(
			'label'   => esc_html__( 'Features – Section Title', 'fleetlink' ),
			'section' => 'fleetlink_features',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'features_description',
		array(
			'default'           => esc_html__( 'FleetLink łączy śledzenie GPS, analizę kierowców, zarządzanie serwisem i optymalizację kosztów w jednej intuicyjnej platformie.', 'fleetlink' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'features_description',
		array(
			'label'   => esc_html__( 'Features – Description', 'fleetlink' ),
			'section' => 'fleetlink_features',
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'fleetlink_customize_register' );

/* =========================================================
   CUSTOMIZER HELPER: checkbox sanitize
   ========================================================= */

if ( ! function_exists( 'fleetlink_sanitize_checkbox' ) ) {
	function fleetlink_sanitize_checkbox( $checked ) {
		return ( isset( $checked ) && true === $checked ) ? true : false;
	}
}

/* =========================================================
   SLIDER HELPER FUNCTIONS
   ========================================================= */

/**
 * Return demo default values for each slider slide field.
 *
 * @param int    $slide 1-based slide index.
 * @param string $field Field name.
 * @return string
 */
function fleetlink_slider_default( $slide, $field ) {
	$defaults = array(
		1 => array(
			'eyebrow'     => 'Monitoring GPS',
			'title'       => 'Każdy pojazd na mapie – <span class="highlight">w czasie rzeczywistym</span>',
			'description' => 'Śledź pozycję całej floty z dokładnością do 5 metrów. Historia tras, zdarzenia i powiadomienia natychmiastowe. Pełna kontrola 24/7.',
			'btn_text'    => 'Wypróbuj za darmo',
			'btn_url'     => '#pricing',
		),
		2 => array(
			'eyebrow'     => 'Zachowanie Kierowcy',
			'title'       => 'Eco-driving, który realnie <span class="highlight">obniża koszty paliwa</span>',
			'description' => 'Analizuj styl jazdy, nagradzaj najlepszych kierowców i redukuj wydatki na paliwo o 15–20%. Moduł dostępny od planu Pro.',
			'btn_text'    => 'Poznaj moduł',
			'btn_url'     => '/driver-behavior/',
		),
		3 => array(
			'eyebrow'     => 'Zarządzanie Serwisem',
			'title'       => 'Zero nieplanowanych przestojów dzięki <span class="highlight">proaktywnemu serwisowi</span>',
			'description' => 'Automatyczne przypomnienia, historia przeglądów i predykcyjne alerty zapobiegają awariom, które zatrzymują Twoją flotę.',
			'btn_text'    => 'Dowiedz się więcej',
			'btn_url'     => '/serwis/',
		),
		4 => array(
			'eyebrow'     => 'Telematyka Wideo',
			'title'       => 'Pełna dokumentacja zdarzeń drogowych <span class="highlight">z kamerami HD</span>',
			'description' => 'Nagrania z kamer zintegrowane z systemem GPS. Dowód w sporach z ubezpieczycielami i przy roszczeniach odszkodowawczych.',
			'btn_text'    => 'Poznaj kamery',
			'btn_url'     => '/telematyka-wideo/',
		),
		5 => array(
			'eyebrow'     => 'Centrum Raportów',
			'title'       => 'Raporty, które przekładają się <span class="highlight">na realne decyzje</span>',
			'description' => 'Automatyczne raporty tygodniowe i miesięczne z kluczowymi wskaźnikami KPI dla każdej floty. Eksport do PDF i Excel.',
			'btn_text'    => 'Sprawdź raporty',
			'btn_url'     => '/raporty/',
		),
	);

	if ( isset( $defaults[ $slide ][ $field ] ) ) {
		return $defaults[ $slide ][ $field ];
	}
	return '';
}

/**
 * Return a decorative SVG icon for the given zero-based slide index.
 *
 * @param int $idx 0-based index.
 * @return string  Safe SVG markup.
 */
function fleetlink_slider_deco_icon( $idx ) {
	$icons = array(
		// GPS pin
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width=".6"><circle cx="12" cy="10" r="3"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="12" r="9" stroke-dasharray="2 4" opacity=".4"/><circle cx="12" cy="12" r="5" stroke-dasharray="1 3" opacity=".3"/></svg>',
		// Driver steering
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width=".6"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/><path d="M12 2v4M12 18v4M2 12h4M18 12h4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" opacity=".4"/></svg>',
		// Wrench / service
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width=".6"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3-3a6 6 0 01-7.4 7.4l-6.3 6.3a2.1 2.1 0 01-3-3L10.3 9a6 6 0 017.4-7.4l-3 3z"/><path d="M6 18l2-2" opacity=".4"/></svg>',
		// Video camera
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width=".6"><rect x="2" y="6" width="15" height="12" rx="2"/><polygon points="22,7 17,10 17,14 22,17"/><circle cx="9.5" cy="12" r="3" opacity=".4"/></svg>',
		// Chart / reports
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width=".6"><path d="M9 17v-6M12 17v-3M15 17v-9M6 17v-2"/><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 3v6" opacity=".4"/></svg>',
	);

	$safe_idx = $idx % count( $icons );
	return $icons[ $safe_idx ];
}

/* =========================================================
   EXCERPT
   ========================================================= */

function fleetlink_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'fleetlink_excerpt_length', 999 );

function fleetlink_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'fleetlink_excerpt_more' );

/* =========================================================
   BODY CLASSES
   ========================================================= */

function fleetlink_body_classes( $classes ) {
	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'single-page-layout';
	}

	if ( is_front_page() ) {
		$classes[] = 'is-frontpage';
	}

	if ( is_page_template( 'page-contact.php' ) ) {
		$classes[] = 'page-contact-template';
	}

	return $classes;
}
add_filter( 'body_class', 'fleetlink_body_classes' );

/* =========================================================
   HELPER FUNCTIONS
   ========================================================= */

/**
 * Get the SVG icon markup for a given icon name.
 */
function fleetlink_icon( $name, $class = '' ) {
	$icons = array(
		'location-pin' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
		'truck'        => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>',
		'chart'        => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M3.5 18.49l6-6.01 4 4L22 6.92l-1.41-1.41-7.09 7.97-4-4L2 16.99z"/></svg>',
		'shield'       => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>',
		'bolt'         => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>',
		'phone'        => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>',
		'mail'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>',
		'address'      => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
		'check'        => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>',
		'close'        => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>',
		'cart'         => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96C5 16.1 6.1 17 7.2 17H19v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63H15.5c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>',
		'arrow-right'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>',
		'arrow-up'     => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/></svg>',
		'star'         => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>',
		'play'         => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>',
		'settings'     => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/></svg>',
		'wifi'         => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/></svg>',
		'map'          => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/></svg>',
		'alert'        => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>',
		'fuel'         => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19.77 7.23l.01-.01-3.72-3.72-1.06 1.06 2.35 2.35C16.4 7.64 16 8.3 16 9c0 1.1.9 2 2 2s2-.9 2-2c0-.48-.18-.92-.47-1.26zM18 11c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-5.5 1.5v-6c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v14c0 .55.45 1 1 1h8c.55 0 1-.45 1-1V12.5zm-2 6.5H5v-5h5.5v5zM5 12.5V7.5h5.5v5H5z"/></svg>',
		'grid'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h8v8H3zm10 0h8v8h-8zM3 13h8v8H3zm10 0h8v8h-8z"/></svg>',
		'list'         => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/></svg>',
		'search'       => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>',
		'fb'           => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
		'tw'           => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
		'li'           => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>',
		'yt'           => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20.06 12 20.06 12 20.06s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon fill="#fff" points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>',
		'ig'           => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
	);

	$svg  = isset( $icons[ $name ] ) ? $icons[ $name ] : '';
	$attr = $class ? ' class="' . esc_attr( $class ) . '"' : '';

	if ( $svg && $class ) {
		// Inject class attribute into the <svg> tag
		$svg = str_replace( '<svg ', '<svg' . $attr . ' ', $svg );
	}

	return $svg;
}

/**
 * Render the WooCommerce cart icon in the header.
 */
function fleetlink_header_cart_icon() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return '';
	}

	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	$url   = wc_get_cart_url();

	ob_start();
	?>
	<a href="<?php echo esc_url( $url ); ?>" class="header-cart-link" aria-label="<?php esc_attr_e( 'Shopping cart', 'fleetlink' ); ?>">
		<?php echo fleetlink_icon( 'cart' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<span class="header-cart-count <?php echo $count > 0 ? 'has-items' : ''; ?>"
		      data-count="<?php echo esc_attr( $count ); ?>">
			<?php echo esc_html( $count ); ?>
		</span>
	</a>
	<?php
	return ob_get_clean();
}

/**
 * Schema.org Organization markup output in footer.
 */
function fleetlink_schema_org() {
	$phone   = get_theme_mod( 'company_phone', '+48 22 123 456 789' );
	$email   = get_theme_mod( 'company_email', 'contact@fleetlink.pl' );
	$address = get_theme_mod( 'company_address', 'ul. Technologiczna 15, 00-001 Warszawa, Poland' );

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Organization',
		'name'        => get_bloginfo( 'name' ),
		'url'         => home_url(),
		'logo'        => get_custom_logo() ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : '',
		'description' => get_bloginfo( 'description' ),
		'telephone'   => $phone,
		'email'       => $email,
		'address'     => $address,
	);

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
	);
}
add_action( 'wp_footer', 'fleetlink_schema_org' );

/* =========================================================
   AJAX HANDLERS
   ========================================================= */

// Contact form handler
function fleetlink_handle_contact_form() {
	check_ajax_referer( 'fleetlink_nonce', 'nonce' );

	$name    = isset( $_POST['name'] )    ? sanitize_text_field( wp_unslash( $_POST['name'] ) )        : '';
	$email   = isset( $_POST['email'] )   ? sanitize_email( wp_unslash( $_POST['email'] ) )             : '';
	$company = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) )      : '';
	$subject = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) )      : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) )  : '';

	if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Proszę wypełnić wszystkie wymagane pola.', 'fleetlink' ) ) );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Please enter a valid email address.', 'fleetlink' ) ) );
	}

	$to      = get_option( 'admin_email' );
	$subject_line = sprintf(
		/* translators: 1: site name, 2: message subject */
		esc_html__( '[%1$s] Contact form: %2$s', 'fleetlink' ),
		get_bloginfo( 'name' ),
		$subject ? $subject : esc_html__( 'New message', 'fleetlink' )
	);

	$body  = sprintf( esc_html__( 'Name: %s', 'fleetlink' ), $name ) . "\n";
	$body .= sprintf( esc_html__( 'Email: %s', 'fleetlink' ), $email ) . "\n";
	if ( $company ) {
		$body .= sprintf( esc_html__( 'Company: %s', 'fleetlink' ), $company ) . "\n";
	}
	$body .= "\n" . esc_html__( 'Message:', 'fleetlink' ) . "\n" . $message;

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		"Reply-To: {$name} <{$email}>",
	);

	$sent = wp_mail( $to, $subject_line, $body, $headers );

	if ( $sent ) {
		wp_send_json_success( array( 'message' => esc_html__( 'Thank you! Your message has been sent.', 'fleetlink' ) ) );
	} else {
		wp_send_json_error( array( 'message' => esc_html__( 'There was a problem sending your message. Please try again.', 'fleetlink' ) ) );
	}
}
add_action( 'wp_ajax_fleetlink_contact', 'fleetlink_handle_contact_form' );
add_action( 'wp_ajax_nopriv_fleetlink_contact', 'fleetlink_handle_contact_form' );

/* =========================================================
   INCLUDE ADDITIONAL FILES
   ========================================================= */

require_once FLEETLINK_DIR . '/inc/class-walker-nav-menu.php';
