<?php
/**
 * The template for displaying the front page.
 *
 * @package MomiPro_Theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="landing-page-section">
				<h1>Welcome to MomiPro</h1>
				<p>Your one-stop marketplace for the best products from top brands.</p>
			</div>

			<div class="featured-brands-section">
				<h2>Featured Brands</h2>
				<?php
				// Example of how to display featured brands.
				// This would typically be implemented with custom post types or by querying vendors.
				echo '<ul>';
				echo '<li>Brand 1</li>';
				echo '<li>Brand 2</li>';
				echo '<li>Brand 3</li>';
				echo '</ul>';
				?>
			</div>

			<div class="featured-products-section">
				<h2>Featured Products</h2>
				<?php echo do_shortcode('[products limit="4" columns="4" visibility="featured" ]'); ?>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
