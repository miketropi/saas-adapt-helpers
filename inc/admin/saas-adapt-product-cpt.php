<?php 
/**
 * saas-adapt product custom post type register
 * 
 * @since 1.0.0
 * @version 1.0.0
 */

add_action('init', 'SAH_product_custom_post_type_register');
function SAH_product_custom_post_type_register() {
	$args = [
    'label'              => __('Products', 'saas-adapt-helpers'),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => ['slug' => 'saas-adapt-product'],
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
    'menu_icon'          => 'dashicons-archive',
  ];

	register_post_type('saas-adapt-product', $args);

  // Features custom tax
	register_taxonomy('product-pricing-options', ['saas-adapt-product'], [
    'public'            => false,
    'hierarchical'      => true,
		'label'             => __('Pricing Options', 'saas-adapt-helpers'),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => ['slug' => 'product-pricing-options'],
  ]);

  // Features custom tax
	register_taxonomy('product-features', ['saas-adapt-product'], [
    'public'            => false,
    'hierarchical'      => true,
		'label'             => __('Features', 'saas-adapt-helpers'),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => ['slug' => 'product-features'],
  ]);

  // Deployment custom tax
  register_taxonomy('product-deployment', ['saas-adapt-product'], [
    'public'            => false,
    'hierarchical'      => true,
		'label'             => __('Deployment', 'saas-adapt-helpers'),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => ['slug' => 'product-deployment'],
  ]);

  // Users range custom tax
  register_taxonomy('product-users-range', ['saas-adapt-product'], [
    'public'            => false,
    'hierarchical'      => true,
		'label'             => __('Users Range', 'saas-adapt-helpers'),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => ['slug' => 'product-users-range'],
  ]);
}

