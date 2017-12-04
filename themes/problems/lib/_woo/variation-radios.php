<?php 

//Text Radios
if ( ! function_exists( 'print_attribute_radio' ) ) {
	function print_attribute_radio( $checked_value, $value, $label, $name ) {
		// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
		$checked = sanitize_title( $checked_value ) === $checked_value ? checked( $checked_value, sanitize_title( $value ), false ) : checked( $checked_value, $value, false );

		$input_name = 'attribute_' . esc_attr( $name ) ;
		$esc_value = esc_attr( $value );
		$id = esc_attr( $name . '_v_' . $value );
		$filtered_label = apply_filters( 'woocommerce_variation_option_name', $label );
		printf( '<div class="attribute-attribute attribute-text"><input type="radio" name="%1$s" value="%2$s" id="%3$s" %4$s><label for="%3$s">%5$s</label></div>', $input_name, $esc_value, $id, $checked, $filtered_label );

	}
}

//Swatch Radios
if ( ! function_exists( 'print_attribute_radio_swatch' ) ) {
	function print_attribute_radio_swatch( $checked_value, $value, $label, $name, $swatch_term ) {
		// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
		$checked = sanitize_title( $checked_value ) === $checked_value ? checked( $checked_value, sanitize_title( $value ), false ) : checked( $checked_value, $value, false );

		$input_name = 'attribute_' . esc_attr( $name ) ;
		$esc_value = esc_attr( $value );
		$id = esc_attr( $name . '_v_' . $value );
		$filtered_label = apply_filters( 'woocommerce_variation_option_name', $label );

		//Get Swatch img or Color
		$background 	= '';
		if($swatch_term->get_type() == 'color') {
			$background = 'background-color: '.$swatch_term->get_color();
		} else {
			$background = 'background-image: url('.$swatch_term->get_image_src().')';
		}
	
		printf( '<div class="attribute-attribute attribute-color"><input type="radio" name="%1$s" value="%2$s" id="%3$s" %4$s><label for="%3$s" style="%6$s">%5$s</label></div>', $input_name, $esc_value, $id, $checked, $filtered_label, $background );

	}
}


?>