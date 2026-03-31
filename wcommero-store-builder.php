<?php

/**
 * WCommero – Store Builder for WooCommerce
 *
 * @package     wcommero-store-builder
 * @author      devhasib
 * @copyright   2026 devhasib
 * @license     GPL-2.0-or-later
 *
 * Plugin Name:       WCommero – Store Builder for WooCommerce
 * Plugin URI:        https://profiles.wordpress.org/devhasib/
 * Description:       Display WooCommerce products beautifully with Elementor. Grid, Carousel, Tabs, List & more—fully customizable, responsive, and easy to use.
 * Version:           1.0.4
 * Author:            devhasib
 * Author URI:        https://profiles.wordpress.org/devhasib/
 * Text Domain:       wcommero-store-builder
 * Domain Path:       /languages
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Requires Plugins:  woocommerce, elementor
 *
 */

if (! defined('ABSPATH')) {
	die;
}

/*
 * Define Plugin Dir Path
 * @since 1.0.0
 */
define('WCSB_ROOT_PATH', plugin_dir_path(__FILE__));
define('WCSB_ROOT_URL', plugin_dir_url(__FILE__));
define('WCSB_INC', WCSB_ROOT_PATH . 'inc');
define('WCSB_CSS', WCSB_ROOT_URL . 'assets/css');
define('WCSB_JS', WCSB_ROOT_URL . 'assets/js');
define('WCSB_IMG', WCSB_ROOT_URL . 'assets/img');
define('WCSB_ELEMENTOR', WCSB_ROOT_PATH . 'elementor');

/** Plugin version **/
define('WCSB_VERSION', '1.0.4');

/**
 * Load plugin textdomain.
 */
add_action('plugins_loaded', 'wcsb_textdomain');
if (! function_exists('wcsb_textdomain')) {
	function wcsb_textdomain()
	{
		load_plugin_textdomain('wcommero-store-builder', false, plugin_basename(dirname(__FILE__)) . '/languages');
	}
}

/*
 * Require init file
 */
if (file_exists(WCSB_INC . '/class-wcsb-init.php')) {
	require_once WCSB_INC . '/class-wcsb-init.php';
}
