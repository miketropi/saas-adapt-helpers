<?php 
/**
 * Static 
 * 
 * @since 1.0.0
 */

add_action('wp_enqueue_scripts', 'SAH_enqueue_scripts');

function SAH_enqueue_scripts() {
  wp_enqueue_script('saas-adapt-helpers-js', SAH_URI . '/dist/saas-adapt-helpers.bundle.js', ['jquery'], SAH_VERSION, true);
  wp_enqueue_style('saas-adapt-helpers-css', SAH_URI . '/dist/css/saas-adapt-helpers.bundle.css', false, SAH_VERSION);

  wp_localize_script('saas-adapt-helpers-js', 'SAH_PHP_DATA', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'lang' => []
  ]);
}

add_action('admin_enqueue_scripts', 'SAH_admin_enqueue_scripts');

function SAH_admin_enqueue_scripts() {
  wp_enqueue_script('saas-adapt-helpers-admin-js', SAH_URI . '/dist/saas-adapt-helpers.admin.bundle.js', ['jquery'], SAH_VERSION, true);
}