<?php
/**
 * The template for displaying the front page.
 *
 * @package MomiPro_Theme
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main front-page">

		<section class="hero-section text-center">
			<div class="container">
				<h1 class="display-4">Welcome to MomiPro</h1>
				<p class="lead">Your one-stop marketplace for the best products from top brands.</p>
				<p>
					<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn btn-primary btn-lg">Shop Now</a>
					<a href="/vendor-landing/" class="btn btn-secondary btn-lg">Become a Vendor</a>
				</p>
			</div>
		</section>

		<section class="featured-categories-section">
			<div class="container">
				<h2 class="text-center">Featured Categories</h2>
				<div class="row">
					<?php
						$args = array(
							'taxonomy'     => 'product_cat',
							'number'       => 4,
							'orderby'      => 'count',
							'order'        => 'desc',
							'hide_empty'   => true,
						);
						$product_categories = get_terms( $args );
						if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ){
							foreach ( $product_categories as $category ) {
								$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
								$image = wp_get_attachment_url( $thumbnail_id );
								$image_placeholder = 'https://via.placeholder.com/300x300.png?text=' . urlencode($category->name);
								$image_url = $image ? $image : $image_placeholder;
								
								echo '<div class="col-md-3 text-center">';
								echo '<div class="category-box">';
								echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $category->name ) . '" class="img-fluid">';
								echo '<h3>' . esc_html( $category->name ) . '</h3>';
								echo '<a href="' . esc_url( get_term_link( $category ) ) . '" class="btn btn-outline-primary">Shop Now</a>';
								echo '</div>';
								echo '</div>';
							}
						}
					?>
				</div>
			</div>
		</section>

		<section class="featured-products-section bg-light">
			<div class="container">
				<h2 class="text-center">Featured Products</h2>
				<?php echo do_shortcode('[products limit="8" columns="4" visibility="featured" ]'); ?>
			</div>
		</section>

		<section class="why-choose-us-section">
			<div class="container">
				<h2 class="text-center">Why Choose MomiPro?</h2>
				<div class="row">
					<div class="col-md-4">
						<div class="feature-box">
							<h3>Curated Selection</h3>
							<p>We hand-pick the best products from trusted brands.</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="feature-box">
							<h3>Secure Shopping</h3>
							<p>Your data is safe with us. We use the latest security technologies.</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="feature-box">
							<h3>Fast Shipping</h3>
							<p>We offer fast and reliable shipping on all orders.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="vendor-cta-section text-center bg-light">
			<div class="container">
				<h2>Join Our Marketplace</h2>
				<p class="lead">Are you a brand looking to reach a wider audience? Join MomiPro and start selling today.</p>
				<a href="/vendor-landing/" class="btn btn-primary btn-lg">Learn More</a>
			</div>
		</section>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();