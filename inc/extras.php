<?php
/**
 * Extra Functions
 *
 * Mostly actions and filters that act independently of template files.
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

/**
 * Get Current View
 *
 * @since 1.0
 * @return string
 */
function matilda_get_current_view() {
	$view = '';

	if ( is_post_type_archive( 'book' ) || is_tax( array( 'novelist-genre', 'novelist-series' ) ) ) {
		$view = 'book_archive';
	} elseif ( is_singular( 'book' ) ) {
		$view = 'book_single';
	} elseif ( is_home() || is_archive() || is_search() ) {
		$view = 'blog';
	} elseif ( is_page() ) {
		$view = 'page';
	} elseif ( is_singular() ) {
		$view = 'single';
	}

	return apply_filters( 'matilda/get-current-view', $view );
}

/**
 * Body Classes
 *
 * Adds extra class names to the <body> tag.
 *
 * @uses  matilda_get_current_view()
 * @uses  matilda_get_sidebar_locations()
 *
 * @param array $classes
 *
 * @since 1.0
 * @return array
 */
function matilda_body_classes( $classes ) {
	/*
	 * Container
	 */
	$layout_style = get_theme_mod( 'layout_style', Matilda_Customizer::defaults( 'layout_style' ) );
	$classes[]    = 'layout-style-' . sanitize_html_class( $layout_style );

	/*
	 * Sidebar Classes
	 */

	// Get current page template.
	$page_template = get_page_template_slug();

	if ( $page_template != 'page-templates/full-width.php' && $page_template != 'page-templates/landing.php' ) {

		// Get the view.
		$view = matilda_get_current_view();

		// Get the option in the Customizer.
		foreach ( matilda_get_sidebar_locations() as $location ) {
			$show_sidebar = get_theme_mod( 'sidebar_' . $location . '_' . $view, Matilda_Customizer::defaults( 'sidebar_' . $location . '_' . $view ) );

			if ( $show_sidebar ) {
				$classes[] = $location . '-sidebar-is-on';
			}
		}
	}

	return $classes;
}

add_filter( 'body_class', 'matilda_body_classes' );

/**
 * Get Sidebar Locations
 *
 * Returns an array of all the sidebar options we have.
 *
 * @since 1.0
 * @return array
 */
function matilda_get_sidebar_locations() {
	$locations = array(
		'left',
		'right'
	);

	return apply_filters( 'matilda/get-sidebar-locations', $locations );
}

/**
 * Custom CSS
 *
 * Generates custom CSS based on Customizer settings. This CSS gets merged into
 * our main theme stylesheet.
 *
 * @since 1.0
 * @return string
 */
function matilda_custom_css() {
	$css = '';

	// Header BG
	$header_bg = get_theme_mod( 'header_image_bg', Matilda_Customizer::defaults( 'header_image_bg' ) );
	if ( $header_bg ) {
		$css .= sprintf( '#masthead { background-image: url(%s); }', esc_url( $header_bg ) );
	}

	// @todo

	return apply_filters( 'matilda/custom-css', $css );
}

/**
 * Adjust Colour Brightness
 *
 * @param string $hex   Base hex colour
 * @param int    $steps Number between -255 (darker) and 255 (lighter)
 *
 * @since 1.0
 * @return string
 */
function matilda_adjust_brightness( $hex, $steps ) {
	$steps = max( - 255, min( 255, $steps ) );

	// Normalize into a six character long hex string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Split into three parts: R, G and B
	$color_parts = str_split( $hex, 2 );
	$return      = '#';

	foreach ( $color_parts as $color ) {
		$color = hexdec( $color ); // Convert to decimal
		$color = max( 0, min( 255, $color + $steps ) ); // Adjust color
		$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	}

	return $return;
}

/**
 * Get Google Fonts URL
 *
 * @since 1.0
 * @return string
 */
function matilda_get_google_fonts_url() {
	$url = 'https://fonts.googleapis.com/css?family=Lato:700|PT+Serif:400,400i,700';

	return apply_filters( 'matilda/google-fonts-url', $url );
}

/**
 * Excerpt Length
 *
 * @param int $length
 *
 * @since 1.0
 * @return int
 */
function matilda_excerpt_length( $length ) {
	return get_theme_mod( 'excerpt_length', Matilda_Customizer::defaults( 'excerpt_length' ) );
}

add_filter( 'excerpt_length', 'matilda_excerpt_length' );

/**
 * Text Before Copyright
 *
 * Adds the text from the Customizer setting before the copyright message.
 *
 * @since 1.0
 * @return void
 */
function matilda_text_before_copyright() {
	$text = get_theme_mod( 'before_credits' );

	if ( ! empty( $text ) || is_customize_preview() ) {
		?>
        <div id="matilda-text-before-copyright">
			<?php echo wpautop( $text ); ?>
        </div>
		<?php
	}
}

add_action( 'matilda/before-copyright', 'matilda_text_before_copyright' );

/**
 * Comment Form Args
 *
 * We put these in a function since they're used in two places.
 *
 * @see   comments.php
 *
 * @since 1.0
 * @return array
 */
function matilda_comment_form_args() {
	$args = array(
		'comment_notes_before' => get_theme_mod( 'comment_notes_before', '' ),
		'comment_notes_after'  => get_theme_mod( 'comment_notes_after', '' ),
		'title_reply_before'   => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h2>'
	);

	return apply_filters( 'matilda/comments/form-args', $args );
}

/**
 * Allow shortcodes in widgets.
 *
 * @since 1.0
 */
add_filter( 'widget_text', 'do_shortcode' );