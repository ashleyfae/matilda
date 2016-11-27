<?php
/**
 * Footer
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

$widget_columns = get_theme_mod( 'footer_widget_columns', Matilda_Customizer::defaults( 'footer_widget_columns' ) );

if ( is_active_sidebar( 'footer' ) ) : ?>
    <div id="footer-widgets" class="widget-area widget-columns-<?php echo esc_attr( absint( $widget_columns ) ); ?>">
        <div class="container">
			<?php dynamic_sidebar( 'footer' ); ?>
        </div>
    </div>
<?php endif; ?>

<footer id="footer">
    <div class="container">
		<?php matilda_footer_menu(); ?>

        <div id="site-info">
			<?php
			do_action( 'matilda/before-copyright' );

			printf(
				__( '%s %s by Novelist.', 'matilda' ),
				matilda_get_copyright(),
				matilda_get_theme_url()
			);

			do_action( 'matilda/after-copyright' );
			?>
        </div>
    </div>
</footer>