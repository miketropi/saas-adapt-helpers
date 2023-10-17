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

    $query_args['meta_query'] = [
      // 'relation' => 'OR',
    ];

    if ( $args['sort_by'] == 'sponsored' ) {

      array_push( $query_args['meta_query'], [
        'key' => 'sponsored',
        'value' => '1',
        'compare'   => '=',
      ] );
    }

    if ( $args['sort_by'] == 'highest_rated' ) {
      array_push( $query_args['meta_query'], [
        'key' => 'rating',
        'value' => '0',
        'compare' => '>',
      ] );
      $query_args['orderby'] = [
        'meta_value' => 'DESC',
      ];
    }

    if ( $args['sort_by'] == 'most_reviews' ) {
      $query_args['meta_key'] = 'total_rating';
      $query_args['meta_value'] = 0;
      $query_args['meta_compare'] = '>';
      $query_args['orderby'] = 'meta_value_num';
      $query_args['order'] = 'DESC';
      // array_push( $query_args['meta_query'], [
      //   'key' => 'total_rating',
      //   'value' => 0,
      //   'compare' => '>',
      // ] );
      // $query_args['orderby'] = [
      //   'meta_value' => 'DESC',
      // ];
    }

    if ( $args['sort_by'] == 'alphabetical' ) {
      $query_args['orderby'] = 'title';
      $query_args['order'] = 'ASC';
    }

    // print_r($query_args);
    
  }



  return new WP_Query(apply_filters('SAH/query_args_products_filter', $query_args, $args));
}

function sah_rating_render( $rating, $total_rating ){
  $rating = !empty( $rating ) ? $rating : 0;

  ob_start();
  ?>
<div class="overall-rating">

    <div>
        <svg style="width: 0; height: 0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <defs>
                <mask id="half_10">
                    <rect x="0" y="0" width="16" height="16" fill="white" />
                    <rect x="10%" y="0" width="16" height="16" fill="black" />
                </mask>

                <mask id="half_20">
                    <rect x="0" y="0" width="16" height="16" fill="white" />
                    <rect x="20%" y="0" width="16" height="16" fill="black" />
                </mask>

                <mask id="half_30">
                    <rect x="0" y="0" width="16" height="16" fill="white" />
                    <rect x="30%" y="0" width="16" height="16" fill="black" />
                </mask>

                <mask id="half_40">
                    <rect x="0" y="0" width="16" height="16" fill="white" />
                    <rect x="40%" y="0" width="16" height="16" fill="black" />
                </mask>

                <mask id="half_50">
                    <rect x="0" y="0" width="16" height="16" fill="white" />
                    <rect x="50%" y="0" width="16" height="16" fill="black" />
                </mask>

                <mask id="half_60">
                    <rect x="0" y="0" width="16" height="16" fill="white" />
                    <rect x="60%" y="0" width="16" height="16" fill="black" />
                </mask>

                <mask id="half_70">
                    <rect x="0" y="0" width="16" height="16" fill="white" />
                    <rect x="70%" y="0" width="16" height="16" fill="black" />
                </mask>

                <mask id="half_80">
                    <rect x="0" y="0" width="16" height="16" fill="white" />
                    <rect x="80%" y="0" width="16" height="16" fill="black" />
                </mask>

                <mask id="half_90">
                    <rect x="0" y="0" width="16" height="16" fill="white" />
                    <rect x="90%" y="0" width="16" height="16" fill="black" />
                </mask>

                <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="star">
                    <path
                        d="M8 0L10.116 5.08754L15.6085 5.52786L11.4238 9.11246L12.7023 14.4721L8 11.6L3.29772 14.4721L4.5762 9.11246L0.391548 5.52786L5.88397 5.08754L8 0Z"
                        fill="#F77F00" />
                </symbol>

                <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="star_gray">
                    <path
                        d="M8 0L10.116 5.08754L15.6085 5.52786L11.4238 9.11246L12.7023 14.4721L8 11.6L3.29772 14.4721L4.5762 9.11246L0.391548 5.52786L5.88397 5.08754L8 0Z"
                        fill="#D3D3D3" />
                </symbol>

            </defs>
        </svg>
    </div>

    <span class="stars" aria-label="<?php echo esc_attr( $rating . 'stars out of 5' ); ?>">
        <?php
          for( $i = 1; $i <= 5; $i++ ) {
            if( $i <= floor($rating) ) {
              echo '<svg class="star active" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="#star"></use>
                    </svg>';
            } else {
              if( $i == ceil($rating) ) {
                $percent = ( $rating - floor($rating) ) * 100;
                echo '<svg class="half-star active" width="16" height="16" viewBox="0 0 16 16">
                        <use xlink:href="#star" mask=url("#half_' . $percent . '")></use>
                      </svg>
                      <svg class="star active" width="16" height="16" viewBox="0 0 16 16">
                        <use xlink:href="#star_gray"></use>
                      </svg>';
              } else {
                echo '<svg class="star active" width="16" height="16" viewBox="0 0 16 16">
                        <use xlink:href="#star_gray"></use>
                      </svg>';
              }
            }
          }
        ?>
    </span>

    <div class="number">
        <?php echo $rating;?>
        <?php 
      if ( !empty($total_rating) ) {
        echo '(' . $total_rating . ')';
      }
      ?>
    </div>

</div>
<?php

  return ob_get_clean();
}