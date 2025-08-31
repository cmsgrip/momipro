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

/**
 * Breadcrumbs
 */
function momipro_get_breadcrumbs() {
    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter = '&gt;'; // delimiter between crumbs
    $home = 'Home'; // text for the 'Home' link
    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb

    global $post;
    $homeLink = get_bloginfo('url');

    if (is_home() || is_front_page()) {
        if ($showOnHome == 1) {
            echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
        }
    } else {
        echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                echo get_category_parents($thisCat->parent, true, ' ' . $delimiter . ' ');
            }
            echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
        } elseif (is_search()) {
            echo $before . 'Search results for "' . get_search_query() . '"' . $after;
        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                if ($showCurrent == 1) {
                    echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                }
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, true, ' ' . $delimiter . ' ');
                if ($showCurrent == 0) {
                    $cats = preg_replace('#^(.+)\s$delimiter\s$#', '$1', $cats);
                }
                echo $cats;
                if ($showCurrent == 1) {
                    echo $before . get_the_title() . $after;
                }
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            echo get_category_parents($cat, true, ' ' . $delimiter . ' ');
            echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
            if ($showCurrent == 1) {
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            }
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1) {
                echo $before . get_the_title() . $after;
            }
        } elseif (is_page() && $post->post_parent) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) {
                    echo ' ' . $delimiter . ' ';
                }
            }
            if ($showCurrent == 1) {
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            }
        } elseif (is_tag()) {
            echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . 'Articles posted by ' . $userdata->display_name . $after;
        } elseif (is_404()) {
            echo $before . 'Error 404' . $after;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                echo ' (';
            }
            echo __('Page') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                echo ')';
            }
        }

        echo '</div>';
    }
}