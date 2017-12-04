<?php

//==============================================================================
//! * Redirect Empty cart to Shop.
//==============================================================================

add_action("template_redirect", 'redirection_function');

function redirection_function() {

    if (is_cart() && sizeof(WC()->cart->cart_contents) == 0) {
        wp_safe_redirect(get_permalink(woocommerce_get_page_id('shop')));
    }

}

//==============================================================================
//! * Change Add to Cart Text.
//==============================================================================

//add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +

function woo_custom_cart_button_text() {

    return __('Add to Bag', 'woocommerce');

}



//==============================================================================
//! * Remove the Password Strength Notification on User Registration.
//==============================================================================

//add_action( 'wp_print_scripts', 'wc_hair_remove_password_strength', 100 );

function wc_hair_remove_password_strength() {
	
	if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
		wp_dequeue_script( 'wc-password-strength-meter' );
	}

}

