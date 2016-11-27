<?php
/**
 * Theme Footer
 *
 * Includes footer widgets, copyright info, theme credits, and footer scripts.
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

do_action( 'matilda/inside-content/bottom' ); ?>

</div> <!-- .container -->

</div> <!-- #content -->

<?php
do_action( 'matilda/before-footer' );

/**
 * Display the footer content. Includes the footer widgets, copyright
 * message, and credit link.
 *
 * @see template-parts/footer.php
 */
matilda_maybe_display( 'footer' );

do_action( 'matilda/after-footer' );
?>

</div> <!-- #page -->

<?php wp_footer(); ?>

</body>
</html>