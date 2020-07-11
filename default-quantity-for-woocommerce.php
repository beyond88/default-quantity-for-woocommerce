<?php

/**
 *
 * @link              https://www.thewpnext.com
 * @since             1.0.0
 * @package           Default_Quantity_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Default Quantity for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/default quantity-for-woocommerce
 * Description:       The easy way to set default quantities in WooCommerce.
 * Version:           1.0.0
 * Author:            Mohiuddin Abdul Kader
 * Author URI:        https://www.thewpnext.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       default-quantity-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DQFWC_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-default-quantity-for-woocommerce-activator.php
 */
function activate_default_quantity_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-default-quantity-for-woocommerce-activator.php';
	Default_Quantity_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-default-quantity-for-woocommerce-deactivator.php
 */
function deactivate_default_quantity_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-default-quantity-for-woocommerce-deactivator.php';
	Default_Quantity_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_default_quantity_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_default_quantity_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-default-quantity-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_default_quantity_for_woocommerce() {

	$plugin = new Default_Quantity_For_Woocommerce();
	$plugin->run();

}
run_default_quantity_for_woocommerce();
