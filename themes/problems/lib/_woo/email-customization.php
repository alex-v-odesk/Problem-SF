<?php 

// OJ global email styles
// 

add_filter( 'woocommerce_email_styles', 'hair_woocommerce_email_styles' );

function hair_woocommerce_email_styles( $css ) {
	$css .= "


	";
	return $css;
}


/* 
 *	Not working in latest WC
 *  ->get_status() not working for some reason
 *  

add_action('woocommerce_email_header', 'hair_conditional_styles', 10, 2);

function hair_conditional_styles($email_heading, $email) {
	write_log($email->object);
	$status = $email->object->get_status();

	if( $status == 'processing') {
		//add_filter( 'woocommerce_email_styles', 'hair_woocommerce_email_styles' );
	}

	if( $status == 'completed') {
		add_filter( 'woocommerce_email_styles', 'hair_woocommerce_email_styles' );
	}

}

*/