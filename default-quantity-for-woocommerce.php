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
 * Requires PHP:      7.2
 * Requires at least: 5.0
 * Tested up to:      6.2
 *
 * WC requires at least: 5.0
 * WC tested up to:   7.8.2
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
	private function __construct() {
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
		define( 'DQFWC_PLUGIN_NAME', 'Default quantity for WooCommerce' );
		define( 'DQFWC_MIN_WC_VERSION', '3.1' );
		define( 'DQFWC_MINIMUM_PHP_VERSION', '5.6.0' );
		define( 'DQFWC_MINIMUM_WP_VERSION', '4.4' );
		define( 'DQFWC_MINIMUM_WC_VERSION', '3.1' );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function init_plugin() {
		new Mak\DefaultQuantityForWoocommerce\Assets();

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			new Mak\DefaultQuantityForWoocommerce\Ajax();
		}

		if ( is_admin() ) {
			new Mak\DefaultQuantityForWoocommerce\Admin();
		}

		new Mak\DefaultQuantityForWoocommerce\Frontend();
		new Mak\DefaultQuantityForWoocommerce\API();
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
