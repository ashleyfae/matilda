<?php
/**
 * Default Template
 *
 * Displays the blog post archive. This template also gets used if a more specific one
 * doesn't exist.
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

global $wp_query;
$post_layout = get_theme_mod( 'post_layout', Matilda_Customizer::defaults( 'post_layout' ) );

get_header();

// Include left sidebar (maybe).
matilda_maybe_show_sidebar( 'left' );
?>

    <main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

            <div id="post-feed" class="layout-<?php echo esc_attr( sanitize_html_class( $post_layout ) ); ?>">

				<?php while ( have_posts() ) : the_post();

					$number_full_posts = get_theme_mod( 'number_full_posts', 0 );

					/**
					 * Display a few full posts.
					 */
					if ( ( ( $number_full_posts > 0 ) && $wp_query->current_post < $number_full_posts && ! is_paged() ) || $post_layout == 'full' ) {

						get_template_part( 'template-parts/content', 'single' );

					} else {

						/**
						 * Allow child themes to modify the template part. By default it's template-parts/content.php.
						 *
						 * @param string  $slug Template slug to use.
						 * @param WP_Post $post Current post.
						 *
						 * @since 1.0
						 */
						$slug          = '';
						$post          = get_post();
						$template_slug = apply_filters( 'matilda/index/template-slug', $slug, $post );

						/**
						 * Include the template part.
						 */
						get_template_part( 'template-parts/content', $template_slug );

					}

				endwhile; ?>

            </div>

            <div class="pagination">
				<?php echo paginate_links(); ?>
            </div>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

    </main>

<?php
// Include right sidebar (maybe).
matilda_maybe_show_sidebar( 'right' );

// Include footer.php.
get_footer();
