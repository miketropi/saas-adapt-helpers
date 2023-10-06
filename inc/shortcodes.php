<?php 
/**
 * Shortcode 
 * 
 * @since 1.0.0
 * @version 1.0.0
 */

add_shortcode('saas-adapt-products', 'SAH_products_shortcode');
function SAH_products_shortcode($atts = []) {
  $a = shortcode_atts([
    'classes' => '',
  ], $atts );

  set_query_var('atts', $a);
  ob_start();
  SAH_load_template('product-listing-page.php'); 
  return ob_get_clean();
}
