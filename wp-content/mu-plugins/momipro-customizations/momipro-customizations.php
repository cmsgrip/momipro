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
