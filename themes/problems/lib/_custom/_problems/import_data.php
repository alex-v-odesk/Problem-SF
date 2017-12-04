<?php 

function problemlibrary_import() {
	
    $csvFile = file(get_template_directory() . '/_data/items.csv');
    $cur_Prod = '';    

    global $wpdb;
        
    foreach ($csvFile as $line) {

		//get all data from each line
        $datum = str_getcsv($line);

		//Make the Parent			
		$newProduct = nils_make_parent($datum);
				
    }
    	
}


function nils_make_parent($datum) {

	$productArgs = array(
		'post_title'   => $datum[0],
		'post_status'  => "publish",
		'post_name'    => strtolower($datum[1].'-'.strtolower($datum[0])),
		'post_type'    => "product",
		'post_content' => $datum[5]
	);
	
	$newProduct = wp_insert_post( $productArgs, $wp_error );

	//Set Basic Data
	update_post_meta( $newProduct, '_visibility', 'visible' );
	update_post_meta( $newProduct, 'total_sales', '0');
	update_post_meta( $newProduct, '_downloadable', 'no');
	update_post_meta( $newProduct, '_virtual', 'no');
	//update_post_meta( $newProduct, '_regular_price', '' );
	//update_post_meta( $newProduct, '_sale_price', '' );
	update_post_meta( $newProduct, '_purchase_note', "" );
	update_post_meta( $newProduct, '_featured', "no" );
	update_post_meta( $newProduct, '_weight', "" );
	update_post_meta( $newProduct, '_length', "" );
	update_post_meta( $newProduct, '_width', "" );
	update_post_meta( $newProduct, '_height', "" );
	update_post_meta( $newProduct, '_sku', '');
	update_post_meta( $newProduct, '_product_attributes', '');
	update_post_meta( $newProduct, '_sale_price_dates_from', "" );
	update_post_meta( $newProduct, '_sale_price_dates_to', "" );
	//update_post_meta( $newProduct, '_price', '' );
	update_post_meta( $newProduct, '_sold_individually', "no" );
	update_post_meta( $newProduct, '_manage_stock', "yes" );
	update_post_meta( $newProduct, '_backorders', "no" );
	update_post_meta( $newProduct, '_stock', $datum[3] );
	update_post_meta( $newProduct, '_downloadable_files ', '');
	update_post_meta( $newProduct, '_download_limit', '');
	update_post_meta( $newProduct, '_download_expiry', '');
	update_post_meta( $newProduct, '_download_type', '');


	//SET Product Style
	wp_set_object_terms( $newProduct, $datum[1], 'author');
	wp_set_object_terms( $newProduct, $datum[2], 'product_cat');

	//SET Product Availability
	switch (strtolower($datum[4])) {
	    case "archive / no lending":
			wp_set_object_terms( $newProduct, 'no-lending', 'object_availability');
	        break;
	    case "borrow me":
			wp_set_object_terms( $newProduct, 'borrow', 'object_availability');
	        break;
	    case "borrow me - nmm":
			wp_set_object_terms( $newProduct, 'borrow-me-nmm', 'object_availability');
	        break;
	    default:
			wp_set_object_terms( $newProduct, 'purchase', 'object_availability');
			update_post_meta( $newProduct, '_price', $datum[4] );
			update_post_meta( $newProduct, '_regular_price', $datum[4] );
	}

	return $newProduct;	
}