<?php
/**
 * Template part for the header. Inserted into header.php.
 *
 * Contains announcement, header image, and navigation.
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

/*
 * Display the announcement bar.
 */
get_template_part( 'template-parts/announcement' );
?>

<header id="masthead" role="banner">
	<div class="container">
		<div class="site-branding">
			<?php if ( get_header_image() ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" alt="<?php echo esc_attr( strip_tags( get_bloginfo( 'name' ) ) ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>">
				</a>
			<?php endif; ?>

			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</h1>

			<?php
			// Description / Tagline.
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) {
				echo '<p class="site-description">' . $description . '</p>';
			}
			?>
		</div>
	</div>
</header>

	<nav id="site-navigation" class="main-navigation" role="navigation">
		<div class="container">
			<button class="menu-toggle" aria-controls="main-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'matilda' ); ?></button>
			<?php matilda_main_menu(); ?>
		</div>
	</nav>

<?php if ( is_active_sidebar( 'below-header' ) ) : ?>
	<div id="below-header-widget" class="widget-area">
		<?php dynamic_sidebar( 'below-header' ); ?>
	</div>
<?php endif; ?>