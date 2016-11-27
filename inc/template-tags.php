<?php
/**
 * Template Tags
 *
 * Functions used throughout the template files.
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

/**
 * Maybe Display Region
 *
 * Include a template part if it's enabled for the current page.
 *
 * @param string $region
 *
 * @since 1.0
 * @return void
 */
function matilda_maybe_display( $region = '' ) {
	$allowed_regions = array(
		'header',
		'footer'
	);

	if ( ! in_array( $region, apply_filters( 'matilda/allowed-regions', $allowed_regions ) ) ) {
		return;
	}

	$view          = matilda_get_current_view();
	$page_template = get_page_template_slug();

	if ( $page_template == 'page-templates/landing.php' ) {
		return;
	}

	$show_region = get_theme_mod( 'show_' . $region . '_' . $view, true );

	if ( $show_region ) {
		get_template_part( 'template-parts/' . $region );
	}
}

/**
 * Maybe Show Sidebar
 *
 * Sidebar is included if it's turned on in the settings panel.
 *
 * @uses  matilda_get_current_view()
 *
 * @param string $location
 *
 * @since 1.0
 * @return void
 */
function matilda_maybe_show_sidebar( $location = 'right' ) {
	// Get the view.
	$view = matilda_get_current_view();

	// Get the option in the Customizer.
	$show_sidebar = get_theme_mod( 'sidebar_' . $location . '_' . $view, Matilda_Customizer::defaults( 'sidebar_' . $location . '_' . $view ) );

	if ( $show_sidebar ) {
		get_sidebar( $location );
	}
}

/**
 * Post Footer
 *
 * Displays the list of tags.
 *
 * @since 1.0
 * @return void
 */
function matilda_entry_footer() {
	?>
    <footer class="entry-footer">
		<?php the_tags( '<span class="post-tags"><i class="fa fa-tags"></i> ', ', ', '</span>' ); ?>
    </footer>
	<?php
}

/**
 * Main Navigation Menu
 *
 * @since 1.0
 * @return void
 */
function matilda_main_menu() {
	wp_nav_menu( array(
		'theme_location' => 'main',
		'menu_id'        => 'main-menu'
	) );
}

/**
 * Footer Menu
 *
 * @since 1.0
 * @return void
 */
function matilda_footer_menu() {
	wp_nav_menu( array(
		'theme_location' => 'footer',
		'menu_id'        => 'footer-menu'
	) );
}

/**
 * Get Copyright Message
 *
 * @since 1.0
 * @return string
 */
function matilda_get_copyright() {
	$default = sprintf( __( 'Copyright %s %s. All Rights Reserved.', 'matilda' ), date( 'Y' ), get_bloginfo( 'name' ) );
	$message = get_theme_mod( 'copyright_message', $default );

	return apply_filters( 'matilda/get-copyright', '<span id="matilda-copyright">' . $message . '</span>' );
}

/**
 * Get Theme URL
 *
 * Returns an HTML formatted link to where to purchase the theme.
 * This adds the user's affiliate ID to the URL if entered in the Customizer options.
 *
 * @since 1.0
 * @return string
 */
function matilda_get_theme_url() {
	$aff_id = get_theme_mod( 'affiliate_id' );
	$url    = 'https://novelistplugin.com/downloads/matilda-theme/';

	if ( empty( $aff_id ) || ! is_numeric( $aff_id ) ) {
		$new_url = $url;
	} else {
		$new_url = add_query_arg( array( 'ref' => intval( $aff_id ) ), $url );
	}

	return apply_filters( 'matilda/theme-link', '<a href="' . esc_url( $new_url ) . '" id="matilda-credit-link" target="_blank" rel="nofollow">' . __( 'Novelist Theme', 'matilda' ) . '</a>' );
}