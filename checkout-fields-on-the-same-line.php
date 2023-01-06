<?php

/**
 * Postcode and City fields on the same line
 */
add_filter( 'woocommerce_default_address_fields' , 'edit_checkout_fields', 9999 );
function edit_checkout_fields( $fields ) {
    // Change class
    $fields['postcode']['class'][0] = 'form-row-first';
    $fields['city']['class'][0] = 'form-row-last';
    return $fields;
}

?>
