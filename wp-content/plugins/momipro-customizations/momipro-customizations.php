<?php
/**
 * Plugin Name: MomiPro Customizations
 * Description: Adds custom functionality for the MomiPro marketplace, including KYC fields for vendor registration.
 * Version: 1.0
 * Author: Gemini
 */

// Add KYC fields to the Dokan vendor registration form
add_action( 'dokan_seller_registration_field_after', 'momipro_add_kyc_fields' );

function momipro_add_kyc_fields() {
    ?>
    <div class="form-row">
        <label for="dokan_company_id">Company ID / VAT Number <span class="required">*</span></label>
        <input type="text" class="input-text form-control" name="dokan_company_id" id="dokan_company_id" value="<?php if ( ! empty( $_POST['dokan_company_id'] ) ) echo esc_attr( $_POST['dokan_company_id'] ); ?>" required="required" />
    </div>
    <div class="form-row">
        <label for="dokan_tax_document">Tax Document (PDF) <span class="required">*</span></label>
        <input type="file" class="input-text form-control" name="dokan_tax_document" id="dokan_tax_document" accept=".pdf" required="required" />
    </div>
    <?php
}

// Save KYC fields
add_action( 'dokan_new_seller_created', 'momipro_save_kyc_fields', 10, 2 );

function momipro_save_kyc_fields( $vendor_id, $dokan_settings ) {
    if ( isset( $_POST['dokan_company_id'] ) ) {
        update_user_meta( $vendor_id, 'dokan_company_id', sanitize_text_field( $_POST['dokan_company_id'] ) );
    }

    if ( isset( $_FILES['dokan_tax_document'] ) ) {
        // Handle file upload
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        $uploaded_file = wp_handle_upload( $_FILES['dokan_tax_document'], array( 'test_form' => false ) );

        if ( $uploaded_file && ! isset( $uploaded_file['error'] ) ) {
            update_user_meta( $vendor_id, 'dokan_tax_document', $uploaded_file['url'] );
        }
    }
}

// Add KYC fields to the vendor settings page
add_action( 'dokan_settings_form_bottom', 'momipro_add_kyc_fields_to_settings', 10, 2 );

function momipro_add_kyc_fields_to_settings( $current_user, $profile_info ) {
    $company_id = isset( $profile_info['dokan_company_id'] ) ? $profile_info['dokan_company_id'] : '';
    $tax_document = isset( $profile_info['dokan_tax_document'] ) ? $profile_info['dokan_tax_document'] : '';
    ?>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="dokan_company_id"><?php esc_html_e( 'Company ID / VAT Number', 'dokan-lite' ); ?></label>
        <div class="dokan-w5 dokan-text-left">
            <input type="text" class="dokan-form-control" name="dokan_company_id" id="dokan_company_id" value="<?php echo esc_attr( $company_id ); ?>" />
        </div>
    </div>
    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="dokan_tax_document"><?php esc_html_e( 'Tax Document', 'dokan-lite' ); ?></label>
        <div class="dokan-w5 dokan-text-left">
            <?php if ( $tax_document ) : ?>
                <a href="<?php echo esc_url( $tax_document ); ?>" target="_blank">View Document</a>
            <?php endif; ?>
            <input type="file" class="dokan-form-control" name="dokan_tax_document" id="dokan_tax_document" accept=".pdf" />
        </div>
    </div>
    <?php
}

// Save KYC fields from the vendor settings page
add_action( 'dokan_store_profile_saved', 'momipro_save_kyc_fields_from_settings', 10, 2 );

function momipro_save_kyc_fields_from_settings( $store_id, $dokan_settings ) {
    if ( isset( $_POST['dokan_company_id'] ) ) {
        $dokan_settings['dokan_company_id'] = sanitize_text_field( $_POST['dokan_company_id'] );
    }

    if ( ! empty( $_FILES['dokan_tax_document']['name'] ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        $uploaded_file = wp_handle_upload( $_FILES['dokan_tax_document'], array( 'test_form' => false ) );

        if ( $uploaded_file && ! isset( $uploaded_file['error'] ) ) {
            $dokan_settings['dokan_tax_document'] = $uploaded_file['url'];
        }
    }

    update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );
}

// Create custom pages on theme activation
add_action( 'admin_init', 'momipro_create_pages' );

function momipro_create_pages() {
    $pages = array(
        'vendor-landing' => array(
            'title' => 'Become a Vendor',
            'content' => '<!-- wp:paragraph --><p>This is a placeholder for the vendor landing page content. You can edit this page in the WordPress admin and add your own content.</p><!-- /wp:paragraph -->',
            'template' => 'page-templates/vendor-landing.php'
        ),
        'about-us' => array(
            'title' => 'About Us',
            'content' => '<!-- wp:paragraph --><p>This is a placeholder for the about us page content. You can edit this page in the WordPress admin and add your own content.</p><!-- /wp:paragraph -->',
            'template' => 'page-templates/about-us.php'
        ),
        'contact-us' => array(
            'title' => 'Contact Us',
            'content' => '<!-- wp:paragraph --><p>This is a placeholder for the contact us page content. You can edit this page in the WordPress admin and add your own content.</p><!-- /wp:paragraph -->',
            'template' => 'page-templates/contact-us.php'
        ),
        'blog' => array(
            'title' => 'Blog',
            'content' => ''
        ),
        'faq' => array(
            'title' => 'Help / FAQ',
            'content' => '<!-- wp:paragraph --><p>This is a placeholder for the FAQ page content. You can edit this page in the WordPress admin and add your own content.</p><!-- /wp:paragraph -->',
            'template' => 'page-templates/faq.php'
        ),
        'terms-of-service' => array(
            'title' => 'Terms of Service',
            'content' => '<!-- wp:paragraph --><p>This is a placeholder for the terms of service. Please replace this with your own terms of service.</p><!-- /wp:paragraph -->'
        ),
        'privacy-policy' => array(
            'title' => 'Privacy Policy',
            'content' => '<!-- wp:paragraph --><p>This is a placeholder for the privacy policy. Please replace this with your own privacy policy.</p><!-- /wp:paragraph -->'
        ),
        'return-policy' => array(
            'title' => 'Return Policy',
            'content' => '<!-- wp:paragraph --><p>This is a placeholder for the return policy. Please replace this with your own return policy.</p><!-- /wp:paragraph -->'
        )
    );

    foreach ( $pages as $slug => $page ) {
        // Check if the page already exists
        if ( null == get_page_by_path( $slug ) ) {
            $new_page = array(
                'post_type' => 'page',
                'post_title' => $page['title'],
                'post_content' => $page['content'],
                'post_status' => 'publish',
                'post_author' => 1,
                'post_name' => $slug
            );

            $page_id = wp_insert_post( $new_page );

            if ( ! empty( $page['template'] ) ) {
                update_post_meta( $page_id, '_wp_page_template', $page['template'] );
            }
        }
    }

    // Set up the navigation menu
    $menu_name = 'Main Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu( $menu_name );

        $menu_items = array(
            'Home' => home_url( '/' ),
            'Shop' => get_permalink( wc_get_page_id( 'shop' ) ),
            'Become a Vendor' => home_url( '/vendor-landing/' ),
            'About Us' => home_url( '/about-us/' ),
            'Blog' => home_url( '/blog/' ),
            'Contact Us' => home_url( '/contact-us/' )
        );

        foreach ( $menu_items as $title => $url ) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title' => $title,
                'menu-item-url' => $url,
                'menu-item-status' => 'publish'
            ) );
        }

        // Assign the menu to the primary theme location
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['menu-1'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
