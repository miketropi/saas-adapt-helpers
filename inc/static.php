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

  wp_add_inline_style('saas-adapt-helpers-css', SAT_css_variables_register_plg() );
}

add_action('admin_enqueue_scripts', 'SAH_admin_enqueue_scripts');

function SAH_admin_enqueue_scripts() {
  wp_enqueue_script('saas-adapt-helpers-admin-js', SAH_URI . '/dist/saas-adapt-helpers.admin.bundle.js', ['jquery'], SAH_VERSION, true);
}

function SAT_css_variables_register_plg() {
  $theme_colors = get_field('theme_color', 'option');
  ob_start();
  ?>
:root {
--sat-primary-color: <?php echo isset($theme_colors['primary_color']) ? $theme_colors['primary_color'] : '#003049'; ?>;
--sat-primary-color-2:
<?php echo isset($theme_colors['primary_color_2']) ? $theme_colors['primary_color_2'] : '#D62828'; ?>;
--sat-secondary-color:
<?php echo isset($theme_colors['secondary_color']) ? $theme_colors['secondary_color'] : '#F77F00'; ?>;
--sat-secondary-color-2:
<?php echo isset($theme_colors['secondary_color_2']) ? $theme_colors['secondary_color_2'] : '#FCBF49'; ?>;
--sat-secondary-color-3:
<?php echo isset($theme_colors['secondary_color_3']) ? $theme_colors['secondary_color_3'] : '#EAE287'; ?>;
}
<?php
  return ob_get_clean();
}