<?php 
/**
 * Template tag
 */

function SAH_product_listing_tag() {
  $args = [];
  $query = SAH_get_products($args);
  ?>
<div class="sah-product-listing">

    <div class="filter-mobile" id="filterProduct">Filter</div>

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
            <?php 
            if( has_excerpt() ){
              echo wp_trim_words(strip_shortcodes( get_the_excerpt()), 40 );
            }
            ?>
            <a href="<?php the_permalink();?>">Learn more about <?php the_title();?></a>
        </div>
    </div>
    <?php
  }
}

function SAH_sidebar_listing(){

  $taxonomies = get_taxonomies( [ 'object_type' => [ 'saas-adapt-product' ] ] );
  if ( !empty($taxonomies) ) {
    foreach ($taxonomies as $key => $taxonomy) {

      $taxonomy_details = get_taxonomy( $taxonomy );
      // print_r($taxonomy_details);

      $terms = get_terms( array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
      ) );

      if ( !empty($terms) ) {
        echo "<div class='product-options'>";
          echo "<h4>". $taxonomy_details->label ."</h4>";
          foreach ($terms as $term) { ?>
            <div class="box">
                <input type="checkbox" id="<?php echo $term->slug;?>" name="pricing-options"
                    value="<?php echo $term->slug;?>">
                <label for="<?php echo $term->slug;?>"><?php echo $term->name;?></label><br>
            </div>
          <?php }
        echo "</div>";
      }

    }
  }

}

function SAH_paginations_tag($query) {
  ?>
  <div class="sah-paginations">
  <?php
  $big = 999999999; // need an unlikely integer
  echo paginate_links( array(
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $query->max_num_pages
  ) );
  ?>
  </div> <!-- .sah-paginations -->
<?php
}