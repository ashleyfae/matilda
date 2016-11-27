<?php

/**
 * Customizer Settings
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */
class Matilda_Customizer {

	/**
	 * Theme object
	 *
	 * @var WP_Theme
	 * @access private
	 * @since  1.0
	 */
	private $theme;

	/**
	 * Matilda_Customizer constructor.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function __construct() {

		$theme       = wp_get_theme();
		$this->theme = $theme;

		add_action( 'customize_register', array( $this, 'register_customize_sections' ) );
		add_action( 'customize_preview_init', array( $this, 'live_preview' ) );
	}

	/**
	 * Default Values
	 *
	 * The default values of each Customizer setting.
	 *
	 * @param string $key (Optional) Which setting to retrieve the value for.
	 *
	 * @hooks  :
	 *        `matilda/customizer/defaults` -- Change default values.
	 *
	 * @access public
	 * @since  1.0
	 * @return array|bool|string|mixed
	 */
	public static function defaults( $key = '' ) {

		$defaults = array(
			'header_image_bg'               => get_template_directory_uri() . '/assets/images/header-bg.jpg',
			'text_color'                 => '#485f5c',
			'primary_color'              => '#c5e0dc',
			'secondary_color'            => '#e08e79',
			'layout_style'               => 'full',
			'announcement_text'          => '',
			'announcement_bg_color'      => '#e08e79',
			'announcement_text_color'    => '#ffffff',
			'sidebar_left_book_archive'  => false,
			'sidebar_right_book_archive' => false,
			'sidebar_left_book_single'   => false,
			'sidebar_right_book_single'  => false,
			'post_layout'                => 'list',
			'number_full_posts'          => 0,
			'summary_type'               => 'excerpts',
			'excerpt_length'             => 30,
			'sidebar_left_blog'          => false,
			'sidebar_right_blog'         => true,
			'suppress_archive_headings'  => false,
			'hide_featured_image'        => false,
			'sidebar_left_single'        => false,
			'sidebar_right_single'       => true,
			'sidebar_left_page'          => false,
			'sidebar_right_page'         => true,
			'comment_form_position'      => 'above',
			'comment_notes_before'       => '',
			'comment_notes_after'        => '',
			'footer_widget_columns'      => 3,
			'affiliate_id'               => '',
			'before_credits'             => '',
			'copyright_message'          => sprintf( __( 'Copyright %s %s. All Rights Reserved.', 'matilda' ), date( 'Y' ), get_bloginfo( 'name' ) )
		);

		$defaults = apply_filters( 'matilda/customizer/defaults', $defaults );

		// If a key is entered, but it doesn't exist - return nothing.
		if ( ! empty( $key ) && ! array_key_exists( $key, $defaults ) ) {
			return false;
		}

		// If a key is entered, return a specific value.
		if ( ! empty( $key ) && array_key_exists( $key, $defaults ) ) {
			return $defaults[ $key ];
		}

		// Otherwise, return the entire array.
		return $defaults;

	}

	/**
	 * Add all panels to the Customizer
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function register_customize_sections( $wp_customize ) {

		// Layout
		$wp_customize->add_section( 'layout', array(
			'title'    => esc_html__( 'Layout', 'matilda' ),
			'priority' => 100
		) );

		// Announcement
		$wp_customize->add_section( 'announcement', array(
			'title'       => esc_html__( 'Announcement', 'matilda' ),
			'description' => esc_html__( 'Appears at the top of each page, just above the navigation.', 'matilda' ),
			'priority'    => 102
		) );

		// Book Archive
		$wp_customize->add_section( 'book_archive', array(
			'title'    => esc_html__( 'Book Archive', 'matilda' ),
			'priority' => 103
		) );

		// Book Single
		$wp_customize->add_section( 'book_single', array(
			'title'    => esc_html__( 'Single Book', 'matilda' ),
			'priority' => 104
		) );

		// Blog Archive
		$wp_customize->add_section( 'blog_archive', array(
			'title'    => esc_html__( 'Blog Archive', 'matilda' ),
			'priority' => 105
		) );

		// Single Post
		$wp_customize->add_section( 'single_post', array(
			'title'    => esc_html__( 'Single Post', 'matilda' ),
			'priority' => 106
		) );

		// Page
		$wp_customize->add_section( 'single_page', array(
			'title'    => esc_html__( 'Pages', 'matilda' ),
			'priority' => 107
		) );

		// Comments
		$wp_customize->add_section( 'comments', array(
			'title'    => esc_html__( 'Comments', 'matilda' ),
			'priority' => 108
		) );

		// Footer
		$wp_customize->add_section( 'footer', array(
			'title'    => esc_html__( 'Footer', 'matilda' ),
			'priority' => 210
		) );

		do_action( 'matilda/customizer/register-sections', $wp_customize );

		/*
		 * Populate Sections
		 */

		$this->header_image_section( $wp_customize );
		$this->colours_section( $wp_customize );
		$this->layout_section( $wp_customize );
		$this->announcement_section( $wp_customize );
		$this->book_archive_section( $wp_customize );
		$this->single_book_section( $wp_customize );
		$this->blog_archive_section( $wp_customize );
		$this->single_post_section( $wp_customize );
		$this->single_page_section( $wp_customize );
		$this->comments_section( $wp_customize );
		$this->footer_section( $wp_customize );

		/*
		 * Change existing settings.
		 */

		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		$wp_customize->get_control( 'header_textcolor' )->priority  = 71;
		$wp_customize->get_control( 'background_color' )->section   = 'background_image';
		$wp_customize->get_section( 'background_image' )->title     = esc_html__( 'Background', 'matilda' );

	}

	/**
	 * Section: Header Image
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function header_image_section( $wp_customize ) {

		/* Header Image */
		$wp_customize->add_setting( 'header_image_bg', array(
			'default'           => self::defaults( 'header_image_bg' ),
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_image_bg', array(
			'label'    => esc_html__( 'Header Background Image', 'matilda' ),
			'section'  => 'header_image',
			'settings' => 'header_image_bg'
		) ) );

	}

	/**
	 * Section: Colours
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function colours_section( $wp_customize ) {

		/* Text Colour */
		$wp_customize->add_setting( 'text_color', array(
			'default'           => self::defaults( 'text_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
			'label'    => esc_html__( 'Text Color', 'matilda' ),
			'section'  => 'colors',
			'settings' => 'text_color'
		) ) );

		/* Primary Colour */
		$wp_customize->add_setting( 'primary_color', array(
			'default'           => self::defaults( 'primary_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
			'label'       => esc_html__( 'Primary Color', 'matilda' ),
			'description' => esc_html__( 'Navigation background, highlighted widgets, etc. This should be a lighter color so the "Text Color" (above) can be placed on top of it.' ),
			'section'     => 'colors',
			'settings'    => 'primary_color'
		) ) );

		/* Secondary Colour */
		$wp_customize->add_setting( 'secondary_color', array(
			'default'           => self::defaults( 'secondary_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
			'label'       => esc_html__( 'Secondary Color', 'matilda' ),
			'description' => esc_html__( 'Header title background, footer background, button backgrounds. This should be a darker color so white text can be placed on top of it.' ),
			'section'     => 'colors',
			'settings'    => 'secondary_color'
		) ) );

	}

	/**
	 * Section: Layout
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function layout_section( $wp_customize ) {

		/* Main Layout */
		$wp_customize->add_setting( 'layout_style', array(
			'default'           => self::defaults( 'layout_style' ),
			'sanitize_callback' => array( $this, 'sanitize_layout_style' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'layout_style', array(
			'label'    => esc_html__( 'Container Style', 'matilda' ),
			'type'     => 'radio',
			'choices'  => array(
				'boxed' => esc_html__( 'Boxed', 'matilda' ),
				'full'  => esc_html__( 'Full Width', 'matilda' )
			),
			'section'  => 'layout',
			'settings' => 'layout_style'
		) ) );

	}

	/**
	 * Section: Announcement Bar
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function announcement_section( $wp_customize ) {

		/* Text */
		$wp_customize->add_setting( 'announcement_text', array(
			'default'           => self::defaults( 'announcement_text' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'announcement_text', array(
			'label'    => esc_html__( 'Announcement Text', 'matilda' ),
			'type'     => 'textarea',
			'section'  => 'announcement',
			'settings' => 'announcement_text'
		) ) );

		/* BG */
		$wp_customize->add_setting( 'announcement_bg_color', array(
			'default'           => self::defaults( 'announcement_bg_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'announcement_bg_color', array(
			'label'    => esc_html__( 'Background Color', 'matilda' ),
			'section'  => 'announcement',
			'settings' => 'announcement_bg_color'
		) ) );

		/* Text */
		$wp_customize->add_setting( 'announcement_text_color', array(
			'default'           => self::defaults( 'announcement_text_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'announcement_text_color', array(
			'label'    => esc_html__( 'Text Colour', 'matilda' ),
			'section'  => 'announcement',
			'settings' => 'announcement_text_color'
		) ) );

	}

	/**
	 * Section: Book Archive
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function book_archive_section( $wp_customize ) {

		if ( ! class_exists( 'Novelist' ) ) {
			return;
		}

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_book_archive', array(
			'default'           => self::defaults( 'sidebar_left_book_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_book_archive', array(
			'label'    => esc_html__( 'Show left sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'sidebar_left_book_archive'
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_book_archive', array(
			'default'           => self::defaults( 'sidebar_right_book_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_book_archive', array(
			'label'    => esc_html__( 'Show right sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'sidebar_right_book_archive'
		) ) );

	}

	/**
	 * Section: Single Book
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function single_book_section( $wp_customize ) {

		if ( ! class_exists( 'Novelist' ) ) {
			return;
		}

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_book_single', array(
			'default'           => self::defaults( 'sidebar_left_book_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_book_single', array(
			'label'    => esc_html__( 'Show left sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'book_single',
			'settings' => 'sidebar_left_book_single'
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_book_single', array(
			'default'           => self::defaults( 'sidebar_right_book_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_book_single', array(
			'label'    => esc_html__( 'Show right sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'book_single',
			'settings' => 'sidebar_right_book_single'
		) ) );

	}

	/**
	 * Section: Blog Archive
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function blog_archive_section( $wp_customize ) {

		/* Post Layout */
		$wp_customize->add_setting( 'post_layout', array(
			'default'           => self::defaults( 'post_layout' ),
			'sanitize_callback' => array( $this, 'sanitize_post_layout' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'post_layout', array(
			'label'    => esc_html__( 'Post Archive Layout', 'matilda' ),
			'type'     => 'radio',
			'choices'  => array(
				'full'       => esc_html__( 'Full Posts', 'matilda' ),
				'grid-2-col' => esc_html__( '2 Column Grid', 'matilda' ),
				'grid-3-col' => esc_html__( '3 Column Grid', 'matilda' ),
				'list'       => esc_html__( 'List', 'matilda' )
			),
			'section'  => 'blog_archive',
			'settings' => 'post_layout'
		) ) );

		/* Number of Full Posts */
		$wp_customize->add_setting( 'number_full_posts', array(
			'default'           => self::defaults( 'number_full_posts' ),
			'sanitize_callback' => 'absint'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'number_full_posts', array(
			'label'       => esc_html__( 'Number of Full Posts', 'matilda' ),
			'description' => esc_html__( 'This setting is ignored if you\'ve chosen "Full Posts" above.', 'matilda' ),
			'type'        => 'number',
			'section'     => 'blog_archive',
			'settings'    => 'number_full_posts'
		) ) );

		/* Excerpts vs Full Posts */
		$wp_customize->add_setting( 'summary_type', array(
			'default'           => self::defaults( 'summary_type' ),
			'sanitize_callback' => array( $this, 'sanitize_summary_type' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'summary_type', array(
			'label'    => esc_html__( 'Post Archive Layout', 'matilda' ),
			'type'     => 'radio',
			'choices'  => array(
				'full'     => esc_html__( 'Full Text / Read More Tag', 'matilda' ),
				'excerpts' => esc_html__( 'Automatic Excerpts', 'matilda' ),
				'none'     => esc_html__( 'None', 'matilda' )
			),
			'section'  => 'blog_archive',
			'settings' => 'summary_type'
		) ) );

		/* Excerpt Length */
		$wp_customize->add_setting( 'excerpt_length', array(
			'default'           => self::defaults( 'excerpt_length' ),
			'sanitize_callback' => 'absint'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'excerpt_length', array(
			'label'       => esc_html__( 'Excerpt Length', 'matilda' ),
			'description' => esc_html__( 'Only applies if you\'ve chosen "Automatic Excerpts" above.', 'matilda' ),
			'type'        => 'number',
			'section'     => 'blog_archive',
			'settings'    => 'excerpt_length'
		) ) );

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_blog', array(
			'default'           => self::defaults( 'sidebar_left_blog' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_blog', array(
			'label'    => esc_html__( 'Show left sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'sidebar_left_blog'
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_blog', array(
			'default'           => self::defaults( 'sidebar_right_blog' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_blog', array(
			'label'    => esc_html__( 'Show right sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'sidebar_right_blog'
		) ) );

		/* Suppress Archive Headings */
		$wp_customize->add_setting( 'suppress_archive_headings', array(
			'default'           => self::defaults( 'suppress_archive_headings' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'suppress_archive_headings', array(
			'label'    => esc_html__( 'Suppress archive headings (i.e. "Category: Books")', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'suppress_archive_headings'
		) ) );

	}

	/**
	 * Section: Single Post
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function single_post_section( $wp_customize ) {

		/* Hide Featured Image */
		$wp_customize->add_setting( 'hide_featured_image', array(
			'default'           => self::defaults( 'hide_featured_image' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'hide_featured_image', array(
			'label'    => esc_html__( 'Hide featured image', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'single_post',
			'settings' => 'hide_featured_image'
		) ) );

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_single', array(
			'default'           => self::defaults( 'sidebar_left_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_single', array(
			'label'    => esc_html__( 'Show left sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'single_post',
			'settings' => 'sidebar_left_single'
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_single', array(
			'default'           => self::defaults( 'sidebar_right_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_single', array(
			'label'    => esc_html__( 'Show right sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'single_post',
			'settings' => 'sidebar_right_single'
		) ) );

	}

	/**
	 * Section: Single Page
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function single_page_section( $wp_customize ) {

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_page', array(
			'default'           => self::defaults( 'sidebar_left_page' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_page', array(
			'label'    => esc_html__( 'Show left sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'single_page',
			'settings' => 'sidebar_left_page'
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_page', array(
			'default'           => self::defaults( 'sidebar_right_page' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_page', array(
			'label'    => esc_html__( 'Show right sidebar', 'matilda' ),
			'type'     => 'checkbox',
			'section'  => 'single_page',
			'settings' => 'sidebar_right_page'
		) ) );

	}

	/**
	 * Section: Comments
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function comments_section( $wp_customize ) {

		/* Above or Below */
		$wp_customize->add_setting( 'comment_form_position', array(
			'default'           => self::defaults( 'comment_form_position' ),
			'sanitize_callback' => array( $this, 'sanitize_comment_form_position' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'comment_form_position', array(
			'label'    => esc_html__( 'Comment Form Position', 'matilda' ),
			'type'     => 'radio',
			'choices'  => array(
				'above' => esc_html__( 'Above Comments List', 'matilda' ),
				'below' => esc_html__( 'Below Comments List', 'matilda' )
			),
			'section'  => 'comments',
			'settings' => 'comment_form_position'
		) ) );

		/* Comment Notes Before */
		$wp_customize->add_setting( 'comment_notes_before', array(
			'default'           => self::defaults( 'comment_notes_before' ),
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'comment_notes_before', array(
			'label'    => esc_html__( 'Text Before Form', 'matilda' ),
			'type'     => 'text',
			'section'  => 'comments',
			'settings' => 'comment_notes_before'
		) ) );

		/* Comment Notes After */
		$wp_customize->add_setting( 'comment_notes_after', array(
			'default'           => self::defaults( 'comment_notes_after' ),
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'comment_notes_after', array(
			'label'    => esc_html__( 'Text After Form', 'matilda' ),
			'type'     => 'text',
			'section'  => 'comments',
			'settings' => 'comment_notes_after'
		) ) );

	}

	/**
	 * Section: Footer
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function footer_section( $wp_customize ) {

		/* Number of Widget Columns */
		$wp_customize->add_setting( 'footer_widget_columns', array(
			'default'           => self::defaults( 'footer_widget_columns' ),
			'sanitize_callback' => array( $this, 'sanitize_footer_widget_columns' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_widget_columns', array(
			'label'       => esc_html__( 'Footer Widget Columns', 'matilda' ),
			'description' => esc_html__( 'The number of footer widgets to appear on each row (1-5).', 'matilda' ),
			'type'        => 'number',
			'section'     => 'footer',
			'settings'    => 'footer_widget_columns'
		) ) );

		/* Affiliate ID */
		$wp_customize->add_setting( 'affiliate_id', array(
			'default'           => self::defaults( 'affiliate_id' ),
			'sanitize_callback' => array( $this, 'sanitize_affiliate_id' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'affiliate_id', array(
			'label'       => esc_html__( 'Affiliate ID', 'matilda' ),
			'description' => esc_html__( 'Enter your Nose Graze affiliate ID number to add it to the theme URL in the footer.', 'matilda' ),
			'type'        => 'text',
			'section'     => 'footer',
			'settings'    => 'affiliate_id'
		) ) );

		/* Text before credits */
		$wp_customize->add_setting( 'before_credits', array(
			'default'           => self::defaults( 'before_credits' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'before_credits', array(
			'label'       => esc_html__( 'Footer Text', 'matilda' ),
			'description' => esc_html__( 'Any text you enter in here will appear directly before the copyright line (see below) in the footer.', 'matilda' ),
			'type'        => 'textarea',
			'default'     => '',
			'section'     => 'footer',
			'settings'    => 'before_credits'
		) ) );

		/* Copyright Message */
		$wp_customize->add_setting( 'copyright_message', array(
			'default'           => self::defaults( 'copyright_message' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'copyright_message', array(
			'label'       => esc_html__( 'Copyright Message', 'matilda' ),
			'description' => esc_html__( 'Customize the copyright message. A link to the theme will be inserted after this.', 'matilda' ),
			'type'        => 'textarea',
			'default'     => '',
			'section'     => 'footer',
			'settings'    => 'copyright_message'
		) ) );

	}

	/**
	 * Sanitize Layout Style
	 *
	 * Must be one of our approved choices, otherwise it returns
	 * the default.
	 *
	 * @param mixed $input
	 *
	 * @access public
	 * @since  1.0
	 * @return string
	 */
	public function sanitize_layout_style( $input ) {
		$allowed = array( 'boxed', 'full' );

		if ( in_array( $input, $allowed ) ) {
			return $input;
		}

		return 'full';
	}

	/**
	 * Sanitize Post Layout
	 *
	 * Must be one of our approved choices, otherwise it returns
	 * the default.
	 *
	 * @param string $input
	 *
	 * @access public
	 * @since  1.0
	 * @return string
	 */
	public function sanitize_post_layout( $input ) {
		$valid = array(
			'full',
			'grid-2-col',
			'grid-3-col',
			'list'
		);

		if ( in_array( $input, $valid ) ) {
			return $input;
		}

		return 'list';
	}

	/**
	 * Sanitize Summary Type
	 *
	 * Must be one of our approved choices, otherwise it returns
	 * the default.
	 *
	 * @param string $input
	 *
	 * @access public
	 * @since  1.0
	 * @return string
	 */
	public function sanitize_summary_type( $input ) {
		$valid = array(
			'full',
			'excerpts',
			'none'
		);

		if ( in_array( $input, $valid ) ) {
			return $input;
		}

		return 'excerpts';
	}

	/**
	 * Sanitize On/Off
	 *
	 * Must be one of our approved choices, otherwise it returns
	 * the default.
	 *
	 * @param mixed $input
	 *
	 * @access public
	 * @since  1.0
	 * @return string
	 */
	public function sanitize_on_off( $input ) {
		$valid = array(
			'on',
			'off'
		);

		if ( in_array( $input, $valid ) ) {
			return $input;
		}

		return 'on';
	}

	/**
	 * Sanitize Checkbox
	 *
	 * @param $input
	 *
	 * @access public
	 * @since  1.0
	 * @return bool
	 */
	public function sanitize_checkbox( $input ) {
		return ( $input === true ) ? true : false;
	}

	/**
	 * Sanitize Footer Widget Columns
	 *
	 * We only allow integers between 1 and 5.
	 *
	 * @param int $input
	 *
	 * @access public
	 * @since  1.0
	 * @return int
	 */
	public function sanitize_footer_widget_columns( $input ) {
		$sanitized_input = absint( $input );

		if ( ( 1 <= $sanitized_input ) && ( $sanitized_input <= 5 ) ) {
			return $sanitized_input;
		}

		return 4;
	}

	/**
	 * Sanitize Comment Form Position
	 *
	 * Must be one of our approved choices, otherwise it returns
	 * the default.
	 *
	 * @param mixed $input
	 *
	 * @access public
	 * @since  1.0
	 * @return string
	 */
	public function sanitize_comment_form_position( $input ) {
		$allowed = array(
			'above',
			'below'
		);

		if ( in_array( $input, $allowed ) ) {
			return $input;
		}

		return 'above';
	}

	/**
	 * Sanitize Affiliate ID
	 *
	 * Must be a positive integer. But we also allow an empty string.
	 *
	 * @param mixed $input
	 *
	 * @access public
	 * @since  1.0
	 * @return string
	 */
	public function sanitize_affiliate_id( $input ) {
		return ( empty( $input ) ) ? '' : absint( $input );
	}

	/**
	 * Add JavaScript
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function live_preview() {

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script(
			'matilda-customizer',
			get_template_directory_uri() . '/assets/js/customizer-preview' . $suffix . '.js',
			array( 'jquery', 'customize-preview' ),
			$this->theme->get( 'Version' ),
			true
		);

	}

}