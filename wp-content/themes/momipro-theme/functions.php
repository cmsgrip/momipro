<?php
/**
 * MomiPro Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package MomiPro_Theme
 */

if ( ! function_exists( 'momipro_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function momipro_theme_setup() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'momipro-theme' ),
		) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'momipro_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'momipro_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function momipro_theme_scripts() {
	wp_enqueue_style( 'momipro-theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'momipro_theme_scripts' );

/**
 * Add custom scripts to the footer.
 */
function momipro_theme_footer_scripts() {
    if ( is_page_template( 'page-templates/faq.php' ) ) {
        ?>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                var accordionHeaders = document.querySelectorAll('.accordion-header');
                accordionHeaders.forEach(function(header) {
                    header.addEventListener('click', function() {
                        this.parentElement.classList.toggle('active');
                    });
                });
            });
        </script>
        <?php
    }
}
add_action( 'wp_footer', 'momipro_theme_footer_scripts' );