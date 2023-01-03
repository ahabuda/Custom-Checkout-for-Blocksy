/* Snippet to add product image thumbnails for ORDER PAGE, THANK YOU PAGE, MY ACCOUNT PAGE, E-MAIL */

/* Product image thumbnails - ORDER */
add_filter( 'woocommerce_cart_item_name', 'ts_product_image_on_checkout', 10, 3 );
function ts_product_image_on_checkout( $name, $cart_item, $cart_item_key ) {
     
    /* Return if not checkout page */
    if ( ! is_checkout() ) {
        return $name;
    }
     
    /* Get product object */
    $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
 
    /* Get product thumbnail */
    $thumbnail = $_product->get_image(array(58, 58));
 
    /* Add wrapper to image and add some css */
    $image = '<div class="ts-product-image">'
                . $thumbnail .
            '</div>'; 
 
    /* Prepend image to name and return it */
    return $image . $name;
}

/* Product image thumbnails - THANK YOU */
add_filter( 'woocommerce_order_item_name', 'order_received_item_thumbnail_image', 10, 3 );
function order_received_item_thumbnail_image( $item_name, $item, $is_visible ) {
    // Targeting order received page only
    if( ! is_wc_endpoint_url('order-received') ) return $item_name;

    // Get the WC_Product object (from order item)
    $product = $item->get_product();

    if( $product->get_image_id() > 0 ){
        $product_image = '<div class="ts-product-image">' . $product->get_image(array(96, 96)) . '</div>';
        $item_name = $product_image . $item_name;
    }

    return $item_name;
}

/* Product image thumbnails - MY ACCOUNT */
add_filter( 'woocommerce_order_item_name', 'display_product_image_in_order_item', 20, 3 );
function display_product_image_in_order_item( $item_name, $item, $is_visible ) {
    // Targeting view order pages only
    if( is_wc_endpoint_url( 'view-order' ) ) {
        $product   = $item->get_product(); // Get the WC_Product object (from order item)
        $thumbnail = $product->get_image(array( 96, 96)); // Get the product thumbnail (from product object)
        if( $product->get_image_id() > 0 )
            $item_name = '<div class="ts-product-image">' . $thumbnail . '</div>' . $item_name;
    }
    return $item_name;
}


/* Product image thumbnails - E-EMAIL */
add_filter( 'woocommerce_email_order_items_args', 'custom_email_order_items_args', 10, 1 );
function custom_email_order_items_args( $args ) {
    $args['show_image'] = true;
    $args['image_size'] = array( 48, 48 );

    return $args;
}

add_filter( 'woocommerce_order_item_thumbnail', 'add_email_order_item_permalink', 10, 2 ); // Product image
add_filter( 'woocommerce_order_item_name', 'add_email_order_item_permalink', 10, 2 ); // Product name
function add_email_order_item_permalink( $output_html, $item, $bool = false ) {
    // Only email notifications
    if( is_wc_endpoint_url() )
        return $output_html;

    $product = $item->get_product();

    return '<a href="'.esc_url( $product->get_permalink() ).'">' . $output_html . '</a>';
}
