<?php 
/**
 * Helpers
 * 
 * @since 1.0.0
 * @version 1.0.0
 */

/**
  * Load template path
  */
function SAH_load_template($template = '') {
  $root_path = SAH_DIR . 'templates/';
  $template_path = $root_path . $template;
  load_template(apply_filters('SAH/template_path_filter', $template_path, $template));
}

/**
 * Product listing page sidebar enable
 */
function SAH_sidebar_enable() {
  return get_option('sah_filter_sidebar', 'option');
}

/**
 * Query products
 * 
 * @param array $args
 * @return 
 */
function SAH_get_products($args = []) {
  $posts_per_page = get_field('sah_posts_per_page', 'option');

  $default = [
    'post_type' => 'saas-adapt-product',
    'posts_per_page' => $posts_per_page ? $posts_per_page : 20,
    'paged' => 1,
    's' => '',
    'sort_by' => '',
    'filter' => [],
  ];

  $args = wp_parse_args($args, $default);

  $query_args = [
    'post_type' => 'saas-adapt-product',
    'posts_per_page' => $args['posts_per_page'],
    'paged' => $args['paged'],
    'post_status' => 'publish',
  ];

  // Search text
  if(!empty($args['s'])) {
    $query_args['s'] = $args['s'];
  }

  // Filter by tax
  if(count($args['filter']) > 0) {
    $query_args['tax_query'] = [
      'relation' => 'AND',
    ];

    foreach($args['filter'] as $key => $ids) {
      array_push($query_args['tax_query'], [
        'taxonomy' => $key,
        'field' => 'term_id',
        'terms' => explode(',', $ids),
      ]);
    }
  }

  // Order by
  if(!empty($args['sort_by'])) {
    # ... Sort by here!
  }

  return new WP_Query(apply_filters('SAH/query_args_products_filter', $query_args, $args));
}