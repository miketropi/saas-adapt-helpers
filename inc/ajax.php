<?php
function filter_Get_Product(){

    $args = [];
    $args['s'] = $_POST['s'];
    $args['paged'] = $_POST['paged'];
    $args['sort_by'] = $_POST['sort_by'];
    $args['filter'] = json_decode( stripslashes($_POST['filter']) , true );

    $query = SAH_get_products($args);

    ob_start();
    SAH_product_loop_tag($query);
    $dataProduct = ob_get_clean();

    ob_start();
    SAH_paginations_tag( $query, $args['paged'] );
    $dataPagination = ob_get_clean();

    wp_send_json( array( 
        'message' => $args['filter'], 
        'dataProduct' => $dataProduct,
        'dataPagination' => $dataPagination
    ));

    die();

}
add_action('wp_ajax_filter_Get_Product', 'filter_Get_Product'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_filter_Get_Product', 'filter_Get_Product'); // wp_ajax_nopriv_{action}