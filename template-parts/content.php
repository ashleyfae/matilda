<?php
/**
 * Template part for displaying posts.
 *
 * This is loaded into the archive pages (index.php) to display post excerpts
 * and thumbnails.
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

$summary_type = get_theme_mod( 'summary_type', Matilda_Customizer::defaults( 'summary_type' ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	do_action( 'matilda/before-post-thumbnail', get_post() );

	// @todo Thumbnail here
	?>

    <header class="entry-header">
		<?php
		/*
		 * Post Title
		 */
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		do_action( 'matilda/after-post-title', get_post() );
		?>
    </header>

	<?php if ( $summary_type != 'none' ) : ?>
        <div class="entry-content">
			<?php
			$summary_type = get_theme_mod( 'summary_type', 'excerpts' );
			if ( $summary_type == 'excerpts' ) {
				the_excerpt();
			} else {
				the_content( __( 'Keep Reading &raquo;', 'matilda' ) );
			}

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'matilda' ),
				'after'  => '</div>',
			) );
			?>
        </div>
	<?php endif;
	do_action( 'matilda/after-post-content', get_post() );
	?>

</article>
