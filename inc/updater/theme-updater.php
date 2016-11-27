<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( ! class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

$theme = wp_get_theme();

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

// Config settings
	$config = array(
		'remote_api_url' => 'https://novelistplugin.com', // Site where EDD is hosted
		'item_name'      => 'Novelist Theme', // Name of theme
		'theme_slug'     => 'novelist', // Theme slug
		'version'        => $theme->get( 'Version' ), // The current version of this theme
		'author'         => 'Novelist', // The author of this theme
		'download_id'    => '', // Optional, used for generating a license renewal link @todo
		'renew_url'      => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'matilda' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'matilda' ),
		'license-key'               => __( 'License Key', 'matilda' ),
		'license-action'            => __( 'License Action', 'matilda' ),
		'deactivate-license'        => __( 'Deactivate License', 'matilda' ),
		'activate-license'          => __( 'Activate License', 'matilda' ),
		'status-unknown'            => __( 'License status is unknown.', 'matilda' ),
		'renew'                     => __( 'Renew?', 'matilda' ),
		'unlimited'                 => __( 'unlimited', 'matilda' ),
		'license-key-is-active'     => __( 'License key is active.', 'matilda' ),
		'expires%s'                 => __( 'Expires %s.', 'matilda' ),
		'expires-never'             => __( 'Lifetime license - never expires.', 'matilda' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'matilda' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'matilda' ),
		'license-key-expired'       => __( 'License key has expired.', 'matilda' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'matilda' ),
		'license-is-inactive'       => __( 'License is inactive.', 'matilda' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'matilda' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'matilda' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'matilda' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'matilda' ),
		'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'matilda' )
	)

);