/**
 * Move customer order notes field above the checkboxes.
 * Co-author: LoicTheAztec (https://stackoverflow.com/users/3730754/loictheaztec).
 */

// Checkout fields customizations
add_filter( 'woocommerce_checkout_fields' , 'customizing_checkout_fields', 10, 1 );
function customizing_checkout_fields( $fields ) {
    // Remove the Order Notes
    unset($fields['order']['order_comments']);

    // Define custom Order Notes field data array
    $customer_note  = array(
        'type' => 'textarea',
        'class' => array('form-row-wide', 'notes'),
        'label' => __('Order notes', 'woocommerce'),
        //'placeholder' => _x('Notes about you order, e.g. special notes for delivery.', 'placeholder', 'woocommerce'),
		'priority' => 111
    );

    // Set custom Order Notes field
    $fields['billing']['billing_customer_note'] = $customer_note;
	
	return $fields;
}

// Set the custom field 'billing_customer_note' in the order object as a default order note (before it's saved)
add_action( 'woocommerce_checkout_create_order', 'customizing_checkout_create_order', 10, 2 );
function customizing_checkout_create_order( $order, $data ) {
    $order->set_customer_note( isset( $data['billing_customer_note'] ) ? $data['billing_customer_note'] : '' );
}
