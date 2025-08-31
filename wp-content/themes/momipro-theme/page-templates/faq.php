<?php
/**
 * Template Name: FAQ
 *
 * @package MomiPro_Theme
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main faq-page">

		<section class="hero-section text-center">
			<div class="container">
				<h1>Help & FAQ</h1>
				<p class="lead">Find answers to common questions below.</p>
			</div>
		</section>

		<section class="faq-section">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h2>For Customers</h2>
						<div class="accordion" id="customer-faq">
							<div class="accordion-item">
								<h3 class="accordion-header">How do I place an order?</h3>
								<div class="accordion-content">
									<p>Simply browse our marketplace, add products to your cart, and proceed to checkout.</p>
								</div>
							</div>
							<div class="accordion-item">
								<h3 class="accordion-header">What is your return policy?</h3>
								<div class="accordion-content">
									<p>You can find our detailed return policy <a href="/return-policy">here</a>.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h2>For Vendors</h2>
						<div class="accordion" id="vendor-faq">
							<div class="accordion-item">
								<h3 class="accordion-header">How do I become a vendor?</h3>
								<div class="accordion-content">
									<p>You can register as a vendor on our <a href="/vendor-landing">Become a Vendor</a> page.</p>
								</div>
							</div>
							<div class="accordion-item">
								<h3 class="accordion-header">What are the commission rates?</h3>
								<div class="accordion-content">
									<p>Our standard commission rate is [Commission Rate]%. You can find more details on our vendor landing page.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
