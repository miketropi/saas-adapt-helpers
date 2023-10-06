<?php 
/**
 * Template tag
 */

function SAH_product_listing_tag() {
  $args = [];
  $query = SAH_get_products($args);
  ?>
  <div class="sah-product-listing">
    <div class="sah-product-listing__items">
      <?php SAH_product_loop_tag($query) ?>
    </div> <!-- .sah-product-listing__items -->
    <?php SAH_paginations_tag($query); ?>
  </div> <!-- .sah-product-listing -->
  <?php
  wp_reset_postdata();
}

function SAH_product_loop_tag($query) {
  while ( $query->have_posts() ) {
    $query->the_post();
    ?>
    <div <?php post_class(apply_filters('SAH/product-loop-item-classes-filter', 'sah-product-item')); ?>>
      <h4><?php the_title(); ?></h4>
    </div>
    <?php
  }
}

function SAH_paginations_tag($q) {
  ?>
  <div class="sah-paginations">

  </div> <!-- .sah-paginations -->
  <?php
}