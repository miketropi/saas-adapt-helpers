<?php 
/**
 * Product lists template 
 * 
 * @since 1.0.0
 * @version 1.0.0
 */

?>
<div class="sah-product-listing-page">
  <div class="sah-product-listing-page__inner">
    <?php do_action('SHA/product-listing-page-before-content'); ?>
    <div class="sah-product-listing-page__content">
      <?php do_action('SAH/product-listing-page-content'); ?>
    </div>
    <?php do_action('SHA/product-listing-page-after-content'); ?>
  </div>
</div>