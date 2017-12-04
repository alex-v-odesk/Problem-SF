<?php 

// Hook in
// add_filter( 'woocommerce_default_address_fields' , 'hair_override_default_fields', 10, 1 );


// set placeholders
// set order
function hair_override_default_fields( $fields ) {

	//add Placeholders
	$fields['first_name']['placeholder'] = 'First Name';
	$fields['last_name']['placeholder'] = 'Last Name';

	$fields['address_1']['placeholder'] = 'Street Address';	
	$fields['address_2']['placeholder'] = 'Apartment, Suite, Unit Etc. (Optional)';

	$fields['city']['placeholder'] = 'City';	
	$fields['postcode']['placeholder'] = 'Postcode';
	$fields['country']['placeholder'] = 'Country';	

    $order = array(


        "first_name",
        "last_name",

        //"company",

        "email",
        "phone",

        "company",

        "address_1",
        "address_2",

        "city",
        "postcode",

        "state",
        "country",

    );

    foreach($order as $field) {
        $ordered_fields[$field] = $fields[$field];
    }

    $fields = $ordered_fields;
    // make filter magic happen here... 
    return $fields; 
}; 


add_filter( 'woocommerce_checkout_fields' , 'hair_override_checkout_fields', 10, 1 );

function hair_override_checkout_fields( $fields ) {

    //Remove fields
    unset($fields['billing']['billing_company']);
    unset($fields['shipping']['shipping_company']);

    // $fields['billing']['billing_first_name']['placeholder'] = 'First Name';
    // $fields['billing']['billing_last_name']['placeholder'] = 'Last Name';    
    $fields['billing']['billing_email']['placeholder'] = 'Email Address';
    $fields['billing']['billing_phone']['placeholder'] = 'Phone Number';
    // $fields['billing']['billing_city']['placeholder'] = 'City';
    // $fields['billing']['billing_postcode']['placeholder'] = 'Zipcode';

    // $fields['shipping']['shipping_first_name']['placeholder'] = 'First Name';
    // $fields['shipping']['shipping_last_name']['placeholder'] = 'Last Name';  
    $fields['shipping']['shipping_email']['placeholder'] = 'Email Address';
    $fields['shipping']['shipping_phone']['placeholder'] = 'Phone Number';
    // $fields['shipping']['shipping_city']['placeholder'] = 'City';
    // $fields['shipping']['shipping_postcode']['placeholder'] = 'Zipcode';




    return $fields;
}