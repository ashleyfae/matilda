<?php
/**
 * Theme Header
 *
 * Displays the <head> section, logo, navigation, and opening content tags.
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'matilda' ); ?></a>

	<?php
	/**
	 * Display the header content. Includes the top bar, header logo/text,
	 * and navigation links.
	 *
	 * @see template-parts/header.php
	 */
	matilda_maybe_display( 'header' );

	do_action( 'matilda/after-header' );
	?>

	<div id="content">

		<div class="container">

			<?php do_action( 'matilda/inside-content/top' ); ?>