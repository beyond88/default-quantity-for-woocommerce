<?php
/**
 *
 * @link              https://github.com/beyond88
 * @since             1.0.0
 * @package           Default_Quantity_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Default Quantity for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/default-quantity-for-woocommerce
 * Description:       The easiest way to set up default quantities for WooCommerce.
 * Version:           2.0.0
 * Author:            Mohiuddin Abdul Kader
 * Author URI:        https://profiles.wordpress.org/hossain88
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       default-quantity-for-woocommerce
 * Domain Path:       /languages
 * Requires PHP:      5.6
 * Requires at least: 4.4
 * Tested up to:      6.0.1
 *
 * WC requires at least: 3.1
 * WC tested up to:   6.7.0
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
/**
 * The main plugin class
 */
final class DefaultQuantityForWoocommerce {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '2.0.0';

    /**
     * Class constructor
     */
    private function __construct() {
        //REMOVE THIS AFTER DEV
        error_reporting(E_ALL ^ E_DEPRECATED);

        $this->define_constants();

        register_activation_hook( DQFWC_FILE, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
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
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'DQFWC_VERSION', self::version );
        define( 'DQFWC_FILE', __FILE__ );
        define( 'DQFWC_PATH', __DIR__ );
        define( 'DQFWC_URL', plugins_url( '', DQFWC_FILE ) );
        define( 'DQFWC_ASSETS', DQFWC_URL . '/assets' );
    }

    /**
     * Initialize the plugin
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
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Mak\DefaultQuantityForWoocommerce\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 */
function DQFWC() {
    return DefaultQuantityForWoocommerce::init();
}

// kick-off the plugin
DQFWC();