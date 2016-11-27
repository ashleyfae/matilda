<?php
/**
 * Sidebar - Right
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

if ( ! is_active_sidebar( 'sidebar' ) && ! is_customize_preview() ) {
	return;
}
?>

<button class="sidebar-toggle" aria-controls="sidebar-right" aria-expanded="false"><?php esc_html_e( 'Show Sidebar', 'matilda' ); ?></button>

<aside id="sidebar-right" class="widget-area" role="complementary">
	<?php
	if ( is_active_sidebar( 'sidebar' ) ) {
		dynamic_sidebar( 'sidebar' );
	} elseif ( is_customize_preview() ) {
		?>
		<p><?php _e( 'Add some widgets to the \'Sidebar - Right\' widget area.', 'matilda' ); ?></p>
		<?php
	}
	?>
</aside>