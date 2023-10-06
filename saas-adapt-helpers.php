<?php 
/*
 * Plugin Name:       SaasAdapt Helpers Plugin
 * Plugin URI:        #
 * Description:       ...
 * Version:           1.0.0
 * Author:            Mike
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        #
 * Text Domain:       saas-adapt-helpers
 */

/**
 * Define
 */
define('SAH_VERSION', '1.0.0');
define('SAH_DIR', plugin_dir_path(__FILE__));
define('SAH_URI', plugin_dir_url(__FILE__));

/**
 * Include
 */
require(SAH_DIR . '/inc/static.php');
require(SAH_DIR . '/inc/helpers.php');
require(SAH_DIR . '/inc/ajax.php');
require(SAH_DIR . '/inc/template-tag.php');
require(SAH_DIR . '/inc/hooks.php');
require(SAH_DIR . '/inc/shortcodes.php');

# Admin
require(SAH_DIR . '/inc/admin/load.php');

/**
 * Boot
 */