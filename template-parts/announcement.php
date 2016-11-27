<?php
/**
 * Announcement Bar
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

$text = get_theme_mod( 'announcement_text', Matilda_Customizer::defaults( 'announcement_text' ) );

if ( ! $text && ! is_customize_preview() ) {
	return;
}

?>
<div id="announcement"<?php echo ( ! $text && is_customize_preview() ) ? ' style="display: none;"' : ''; ?>>
	<?php
	if ( $text ) {
		echo wpautop( $text );
	}
	?>
</div>