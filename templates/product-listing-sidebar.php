<?php 
/**
 * 
 */

?>
<div class="sah-product-listing-page__sidebar">
  <div class="wrap">
    
    <div class="filter-mobile" id="filterProduct">Filter</div>

    <div class="sah-product-listing__search-product">
      <h4>Filter Products:</h4>
      <input type="text" id="searchProductName" placeholder="Search Product Name">
    </div>

    <div class="sah-product-listing__sortby">
      <h4>Sort By:</h4>
      <select name="filterSortBy">
        <option value="sponsored" selected>Sponsored</option>
        <option value="highest_rated">Highest Rated</option>
        <option value="most_reviews">Most Reviews</option>
        <option value="alphabetical">Alphabetical</option>
      </select>
    </div>

    <div class="sah-product-listing__sidebar-inner">
      <div class="close-btn">
        <svg width="24" height="24" class="icon-close" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4.5 4.5L19.5005 19.5005M4.5 19.5005L19.5005 4.5" stroke="#333333" stroke-width="1.5" stroke-linecap="square"></path>
        </svg>
      </div>

      <div class="list_terms">
        <?php do_action('SAH/sidebar_inner'); ?>
      </div>
    </div>

  </div>

</div>