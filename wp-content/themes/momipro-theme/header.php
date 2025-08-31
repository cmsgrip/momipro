<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'momipro-theme' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/momipro-logo.svg" alt="<?php bloginfo( 'name' ); ?>" class="site-logo">
			</a>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div class="container breadcrumb-container">
		<?php
		if ( function_exists( 'momipro_get_breadcrumbs' ) ) {
			momipro_get_breadcrumbs();
		}
		?>
	</div>

	<div id="content" class="site-content">
