<?php
/**
 * Plugin main file.
 * 
 * @link              https://github.com/beyond88/default-quantity-for-woocommerce
 * @since             1.0.0
 * @package           Default_Quantity_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Default Quantity for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/default-quantity-for-woocommerce
 * Description:       Discover the simplest method to establish default quantities for your WooCommerce store effortlessly.
 * Version:           2.0.2
 * Author:            Mohiuddin Abdul Kader
 * Author URI:        https://github.com/beyond88
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       default-quantity-for-woocommerce
 * Domain Path:       /languages
 * Requires Plugins: woocommerce
 * Requires PHP:      7.4
 * Requires at least: 5.9
 * Tested up to:      6.6.2
 *
 * WC requires at least: 8.0.0
 * WC tested up to: 9.3.3
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class.
 */
final class DefaultQuantityForWoocommerce {

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	const VERSION = '2.0.2';

	/**
	 * Class constructor.
	 */
	public function __construct() {
		// REMOVE THIS AFTER DEV
		error_reporting( E_ALL ^ E_DEPRECATED );
		$this->define_constants();
		register_activation_hook( DQFWC_FILE, [ $this, 'activate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * Initializes a singleton instance.
	 *
	 * @return \Default_Quantity_For_Woocommerce
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define the required plugin constants.
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'DQFWC_VERSION', self::VERSION );
		define( 'DQFWC_FILE', __FILE__ );
		define( 'DQFWC_PATH', __DIR__ );
		define( 'DQFWC_URL', plugins_url( '', DQFWC_FILE ) );
		define( 'DQFWC_ASSETS', DQFWC_URL . '/assets' );
		define( 'DQFWC_BASENAME', plugin_basename( __FILE__ ) );
		define( 'DQFWC_PLUGIN_NAME', 'Default Quantity for WooCommerce' );
		define( 'DQFWC_MINIMUM_PHP_VERSION', '7.2' );
		define( 'DQFWC_MINIMUM_WP_VERSION', '5.9' );
		define( 'DQFWC_MINIMUM_WC_VERSION', '8.0' );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function init_plugin() {
		add_action('woocommerce_init', function() {
			if (class_exists('\Automattic\WooCommerce\Utilities\OrderUtil')) {
				$methods = get_class_methods('\Automattic\WooCommerce\Utilities\OrderUtil');
				if (in_array('declare_compatibility', $methods)) {
					\Automattic\WooCommerce\Utilities\OrderUtil::declare_compatibility('custom_order_tables', __FILE__, true);
				}
			}
		});

		new Mak\DefaultQuantityForWoocommerce\Assets();
		new Mak\DefaultQuantityForWoocommerce\Admin();
		new Mak\DefaultQuantityForWoocommerce\Frontend();
	}

	/**
	 * Do stuff upon plugin activation.
	 *
	 * @return void
	 */
	public function activate() {
		$installer = new Mak\DefaultQuantityForWoocommerce\Installer();
		$installer->run();
	}
}

/**
 * Initializes the main plugin.
 */
function DQFWC() {
	return DefaultQuantityForWoocommerce::init();
}

// kick-off the plugin.
DQFWC();
