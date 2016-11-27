<?php
/**
 * Theme Functions
 *
 * Sets up the theme and includes any other required files.
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

if ( ! function_exists( 'matilda_setup' ) ) :

	/**
	 * Setup
	 *
	 * Sets up theme definitions and registers support for WordPress features.
	 *
	 * @since 1.0
	 * @return void
	 */
	function matilda_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'matilda', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 * Also specify the size.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 520, 400, true );

		/*
		 * Register Menus
		 */
		register_nav_menus( array(
			'main'   => esc_html__( 'Main Menu', 'matilda' ),
			'footer' => esc_html__( 'Footer', 'matilda' )
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'matilda/custom-background-args', array(
			'default-color' => 'ffffff'
		) ) );

		// Add support for WooCommerce @TODO
		//add_theme_support( 'woocommerce' );

	}

endif;

add_action( 'after_setup_theme', 'matilda_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @TODO
 *
 * @global int $content_width
 *
 * @since 1.0
 * @return void
 */
function matilda_content_width() {
	$sidebar_enabled = get_theme_mod( 'include_sidebar', true );
	$content_width   = $sidebar_enabled ? 690 : 750;

	$GLOBALS['content_width'] = apply_filters( 'matilda/content-width', $content_width );
}

add_action( 'after_setup_theme', 'matilda_content_width', 0 );

/**
 * Register widget areas.
 *
 * @link  https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @since 1.0
 * @return void
 */
function matilda_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar - Left', 'matilda' ),
		'id'            => 'sidebar-left',
		'description'   => esc_html__( 'Sidebar on the left-hand side.', 'matilda' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar - Right', 'matilda' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Sidebar on the right-hand side.', 'matilda' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Below Header', 'matilda' ),
		'id'            => 'below-header',
		'description'   => esc_html__( 'Appears below the navigation bar and spans across the full page. Ideal for banner ads.', 'matilda' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Below Posts', 'matilda' ),
		'id'            => 'below-posts',
		'description'   => esc_html__( 'Appears below the content on the single post page.', 'matilda' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage', 'matilda' ),
		'id'            => 'homepage',
		'description'   => esc_html__( 'These widgets appear on the static homepage, if configured.', 'matilda' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'matilda' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Footer widgets.', 'matilda' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}

add_action( 'widgets_init', 'matilda_widgets_init' );

/**
 * Enqueue scripts and styles.
 *
 * @uses  wp_get_theme()
 *
 * @since 1.0
 * @return void
 */
function matilda_assets() {
	$matilda = wp_get_theme();
	$version = $matilda->get( 'Version' );

	// Remove Expanding Archives CSS
	wp_deregister_style( 'expanding-archives' );

	// Google Fonts
	wp_enqueue_style( 'matilda-google-fonts', matilda_get_google_fonts_url() );

	// Add styles
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.4.0' );
	wp_enqueue_style( 'matilda', get_stylesheet_uri(), array(), $version );
	wp_add_inline_style( 'matilda', matilda_custom_css() );

	// JavaScript
	wp_enqueue_script( 'matilda', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), $version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'matilda_assets' );

/**
 * Include Updater
 *
 * We use an action so child themes can disable this if necessary.
 *
 * @since 1.0
 * @return void
 */
function matilda_theme_updater() {
	require get_template_directory() . '/inc/updater/theme-updater.php';
}

add_action( 'after_setup_theme', 'matilda_theme_updater' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Custom header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Customizer settings.
 */
require get_template_directory() . '/inc/class-matilda-customizer.php';
new Matilda_Customizer();