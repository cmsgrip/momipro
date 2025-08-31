<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'product-card', $product ); ?>>
	<div class="product-card-inner">
		<div class="product-image-wrapper">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo $product->get_image(); ?>
			</a>
		</div>
		<div class="product-details">
			<div class="product-brand">
				<?php
				$vendor = dokan_get_vendor_by_product( $product->get_id() );
				if ( $vendor ) {
					$vendor_data = $vendor->get_shop_info();
					$store_logo_id = isset( $vendor_data['gravatar'] ) ? $vendor_data['gravatar'] : 0;
					if ( $store_logo_id ) {
						$store_logo_url = wp_get_attachment_url( $store_logo_id );
						echo '<img src="' . esc_url( $store_logo_url ) . '" alt="' . esc_attr( $vendor->get_shop_name() ) . '">';
					} else {
						echo esc_html( $vendor->get_shop_name() );
					}
				}
				?>
			</div>
			<h3 class="woocommerce-loop-product__title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
			<?php if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) : ?>
				<div class="star-rating-container"><?php echo $rating_html; ?></div>
			<?php endif; ?>
			<div class="price-container">
				<?php echo $product->get_price_html(); ?>
			</div>
			<div class="add-to-cart-container">
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
		</div>
	</div>
</li>
