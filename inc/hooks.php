<?php 
/**
 * Hooks 
 * 
 * @since 1.0.0
 * @version 1.0.0
 */

add_action('SHA/product-listing-page-before-content', 'SAH_product_listing_sidebar', 20);
function SAH_product_listing_sidebar() {
  if(SAH_sidebar_enable() != true) return; 
  SAH_load_template('product-listing-sidebar.php');
}

add_action('SAH/product-listing-page-content', 'SAH_product_listing_tag');

add_action('SAH/sidebar_inner', 'SAH_sidebar_listing');

add_filter('acf/load_field/name=sah_products_filter', function ( $field ) {
  $result = array();

  // Get all published Gravity Forms
  $taxonomies = get_taxonomies( [ 'object_type' => [ 'saas-adapt-product' ] ] );

  foreach ( $taxonomies as $taxonomy ) {
    $taxonomy_details = get_taxonomy( $taxonomy );

    $result[ $taxonomy ] = $taxonomy_details->label;
  }

  if ( is_array($result) ) {
      $field['choices'] = array();
      foreach ( $result as $key => $match ) {
          $field['choices'][ $key ] = $match;
      }
  }

  return $field;
}, 100);