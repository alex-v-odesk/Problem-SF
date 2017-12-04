<?php

//==============================================================================
//! * Remove WooCommerce Generator tag, styles, and scripts from the homepage.
//==============================================================================

/* REMOVE STYLES */
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/* REMOVE SCRIPTS */
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99);

function child_manage_woocommerce_styles() {
	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

	//Woo Plugins
	wp_dequeue_script( 'bootstrap-modal' );		
	wp_dequeue_script( 'wc_price_slider' );
	wp_dequeue_script( 'wc-single-product' );
	wp_dequeue_script( 'wc-add-to-cart' );
	wp_dequeue_script( 'wc-cart-fragments' );
	wp_dequeue_script( 'wc-checkout' );
	wp_dequeue_script( 'wc-add-to-cart-variation' );
	wp_dequeue_script( 'wc-cart' );
	wp_dequeue_script( 'wc-chosen' );
	wp_dequeue_script( 'woocommerce' );
	wp_dequeue_script( 'prettyPhoto' );
	wp_dequeue_script( 'prettyPhoto-init' );
	wp_dequeue_script( 'jquery-blockui' );
	wp_dequeue_script( 'jquery-placeholder' );
	wp_dequeue_script( 'fancybox' );
	wp_dequeue_script( 'jqueryui' );

	wp_dequeue_script( 'swatches-and-photos');

	wp_dequeue_script( 'select2');
	wp_dequeue_script( 'wc-country-select');
	wp_deregister_script( 'wc-country-select');

	wp_dequeue_script( 'wc-address-i18n');
	wp_deregister_script( 'wc-wc-address-i18n');

}
	

/* Re/Enqueue wooCommerce specific scripts */
add_action('wp_enqueue_scripts', 'woo_shop_scripts', 100);

function woo_shop_scripts() {

	$scripts = new WC_Frontend_Scripts();
	
	if ("product" == get_post_type() && is_single() || is_checkout() || is_cart() ) {
		$scripts->load_scripts();
	}

}
	
