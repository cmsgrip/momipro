<?php
/**
 * Template Name: Contact Us
 *
 * @package MomiPro_Theme
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main contact-us-page">

		<section class="hero-section text-center">
			<div class="container">
				<h1>Contact Us</h1>
				<p class="lead">We'd love to hear from you. Get in touch with us using the form below.</p>
			</div>
		</section>

		<section class="contact-form-section">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<h2>Send us a Message</h2>
						<p>Please install a contact form plugin like WPForms or Contact Form 7 and paste the shortcode here.</p>
						<div class="contact-form-placeholder">
							[your-contact-form-shortcode]
						</div>
					</div>
					<div class="col-md-4">
						<h2>Contact Information</h2>
						<address>
							<strong>MomiPro, Inc.</strong><br>
							[Your Street Address]<br>
							Cheyenne, WY [Your Zip Code]<br>
							USA<br><br>
							<strong>Email:</strong> <a href="mailto:[Contact Email]">[Contact Email]</a><br>
							<strong>Phone:</strong> [Your Phone Number]
						</address>
					</div>
				</div>
			</div>
		</section>

		<section class="google-map-section">
			<div class="container-fluid">
				<h2 class="text-center">Our Location</h2>
				<div class="map-placeholder text-center">
					<p>Placeholder for Google Map embed code. You can generate this from Google Maps and paste it here.</p>
					<img src="[Placeholder Image URL]" alt="Map" class="img-fluid">
				</div>
			</div>
		</section>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
