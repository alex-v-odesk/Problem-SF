<?php 

//==============================================================================
//! * AJAX Remove from Mini Cart Function.
//==============================================================================

add_action('wp_ajax_qty_cart', 'hair_product_remove');
add_action('wp_ajax_nopriv_qty_cart', 'hair_product_remove');

function hair_product_remove() {

	//Get cart item key
	$cart_item_key = $_POST['cart_item_key'];

	//If it exists, lets remove it
	if($cart_item_key){
		
        WC()->cart->set_quantity( $cart_item_key, 0, true );
        $response_array['status'] = 'success';
	
	} else {

		$response_array['status'] = 'error';
	}

	//Send Response!
    header('Content-type: application/json');
    echo json_encode($response_array);

	exit;
}

?>
