<?php 
/**
 * Template tag
 */

function SAH_product_listing_tag() {
  $args = [];
  $args['sort_by'] = 'sponsored';

  $query = SAH_get_products($args);

  ?>
<div class="sah-product-listing">

    <div id="SAH_filter_selected" class="filters-selected"></div>

    <div class="sah-product-listing__items">
        <?php SAH_product_loop_tag($query) ?>
    </div> <!-- .sah-product-listing__items -->
    <?php SAH_paginations_tag($query, 1); ?>
</div> <!-- .sah-product-listing -->
<?php
  wp_reset_postdata();
}

function SAH_product_loop_tag($query) {
  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      ?>
      <div <?php post_class(apply_filters('SAH/product-loop-item-classes-filter', 'sah-product-item')); ?>>
          <div class="sah-product-item__box">
              <div class="sah-product-item__left">
                  <div class="sah-product-item__feaftured-img">
                      <?php if ( has_post_thumbnail() ) {
                        echo '<img src="'. get_the_post_thumbnail_url() .'" alt="'. get_the_title() .'">';
                      } ?>
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
  }else{
    ?>
    <div class="not-found-product">
      <h4>Your filter returned 0 results.</h4>
    </div>
    <?php
  }
}

function SAH_sidebar_listing(){

  $taxonomies = get_field('sah_products_filter', 'option');

  if ( !empty($taxonomies) ) {
    foreach ($taxonomies as $key => $taxonomy) {

      $taxonomy_details = get_taxonomy( $taxonomy );
      // print_r($taxonomy_details);

      $terms = get_terms( array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'orderby'    => 'ID', 
        'order'      => 'ASC',
      ) );

      if ( !empty($terms) ) {
        echo "<div class='product-options'>";
          echo "<h4>". $taxonomy_details->label ."</h4>";
          foreach ($terms as $term) { ?>
            <div class="box">
                <input type="checkbox" class="sah_checkbox_term" data-tax="<?php echo $term->taxonomy;?>" data-label="<?php echo $term->name;?>" id="<?php echo $term->slug;?>" name="<?php echo $term->slug;?>"
                    value="<?php echo $term->slug;?>">
                <label for="<?php echo $term->slug;?>"><?php echo $term->name;?></label>
            </div>
          <?php }
        echo "</div>";
      }

    }
  }

}

function SAH_paginations_tag($query, $next_page) {
  ?>
  <div class="sah-paginations">
  <?php
  $big = 999999999; // need an unlikely integer
  echo paginate_links( array(
    'base' => site_url() . '%_%',
    'mid_size' => 2,
    'format' => '?paged=%#%',
    'current' => max ( 1, $next_page ),
    'total' => $query->max_num_pages,
    'prev_text' => '<svg width="12px" height="12px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M768 903.232l-50.432 56.768L256 512l461.568-448 50.432 56.768L364.928 512z" fill="#003049" /></svg>',
    'next_text' => '<svg width="12px" height="12px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M256 120.768L306.432 64 768 512l-461.568 448L256 903.232 659.072 512z" fill="#003049" /></svg>',
    ) );
  ?>
  </div>
<?php
}