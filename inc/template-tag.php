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
    <div class="sah-product-item__box">
        <div class="sah-product-item__left">
            <div class="sah-product-item__feaftured-img">
                <img src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php the_title();?>">
            </div>
            <div class="sah-product-item__info">
                <a href="<?php the_permalink();?>">
                    <h3><?php the_title();?></h3>
                </a>

                <?php if ( !empty(get_field('company_name')) ) { ?>
                <div class="company">by <?php echo get_field('company_name');?></div>
                <?php } ?>

                <?php if ( !empty(get_field('rating')) ) { ?>
                <div class="rating">
                    <?php echo sah_rating_render( get_field('rating') , get_field('total_rating') );?>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="sah-product-item__right">
            <a href="<?php the_permalink();?>">View Profile</a>
        </div>
    </div>
    <div class="sah-product-item__description">
        <?php the_excerpt();?>
        <a href="<?php the_permalink();?>">Learn more about <?php the_title();?></a>
    </div>
</div>
<?php
  }
}

function SAH_sidebar_listing(){

  $taxonomies = get_taxonomies( [ 'object_type' => [ 'saas-adapt-product' ] ] );
  print_r($taxonomies);

  $terms_pricing_opts = get_terms( array(
    'taxonomy' => 'product-pricing-options',
    'hide_empty' => false,
  ) );

  $terms_features = get_terms( array(
    'taxonomy' => 'product-features',
    'hide_empty' => false,
  ) );

  $terms_deployment = get_terms( array(
    'taxonomy' => 'product-deployment',
    'hide_empty' => false,
  ) );

  $terms_users_range = get_terms( array(
    'taxonomy' => 'product-users-range',
    'hide_empty' => false,
  ) );

  if ( !empty($terms_pricing_opts) ) {
    echo "<div class='product-options'>";
      echo "<h4>Pricing Options</h4>";
      foreach ($terms_pricing_opts as $term_pricing_opt) { ?>
        <div class="box">
            <input type="checkbox" id="<?php echo $term_pricing_opt->slug;?>" name="pricing-options"
                value="<?php echo $term_pricing_opt->slug;?>">
            <label for="<?php echo $term_pricing_opt->slug;?>"><?php echo $term_pricing_opt->name;?></label><br>
        </div>
      <?php }
    echo "</div>";
  }

  if ( !empty($terms_features) ) {
    echo "<div class='product-options'>";
      echo "<h4>Features</h4>";
      foreach ($terms_features as $term_feature) { ?>
        <div class="box">
            <input type="checkbox" id="<?php echo $term_feature->slug;?>" name="pricing-options"
                value="<?php echo $term_feature->slug;?>">
            <label for="<?php echo $term_feature->slug;?>"><?php echo $term_feature->name;?></label><br>
        </div>
      <?php }
    echo "</div>";
  }

  if ( !empty($terms_deployment) ) {
    echo "<div class='product-options'>";
      echo "<h4>Deployment</h4>";
      foreach ($terms_deployment as $term_deployment) { ?>
        <div class="box">
            <input type="checkbox" id="<?php echo $term_deployment->slug;?>" name="pricing-options"
                value="<?php echo $term_deployment->slug;?>">
            <label for="<?php echo $term_deployment->slug;?>"><?php echo $term_deployment->name;?></label><br>
        </div>
      <?php }
    echo "</div>";
  }

  if ( !empty($terms_users_range) ) {
    echo "<div class='product-options'>";
      echo "<h4>Users</h4>";
      foreach ($terms_users_range as $user_range) { ?>
        <div class="box">
            <input type="checkbox" id="<?php echo $user_range->slug;?>" name="pricing-options"
                value="<?php echo $user_range->slug;?>">
            <label for="<?php echo $user_range->slug;?>"><?php echo $user_range->name;?></label><br>
        </div>
      <?php }
    echo "</div>";
  }
  
}

function SAH_paginations_tag($query) {
  ?>
<div class="sah-paginations">

</div> <!-- .sah-paginations -->
<?php
}