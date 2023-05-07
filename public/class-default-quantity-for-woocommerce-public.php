<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/beyond88
 * @since      1.0.0
 *
 * @package    Default_Quantity_For_Woocommerce
 * @subpackage Default_Quantity_For_Woocommerce/public
 * @subpackage Default_Quantity_For_Woocommerce/public
 * @author     Mohiuddin Abdul Kader <muhin.cse.diu@gmail.com>
 */
class Default_Quantity_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Save default quantity meta value for individual products.
	 *
	 * @since   1.0.0
	 * @params 	array, object		
	 * @return 	array
	*/	
	public function dqfwc_quantity_input_args( $args, $product ) {		

		// Retrieve global default quanity
		$dqfwc_global 		 = get_option( 'woocommerce_default_quantity' );
		if( ! empty( $dqfwc_global ) ) {
			$args['min_value']   = (int) $dqfwc_global;
			$args['input_value'] = (int) $dqfwc_global;
		}

		//Retrieve product category meta
		$dqfwc_product_cats = wp_get_post_terms( $product->get_id(), 'product_cat' );
		foreach( $dqfwc_product_cats as $term ) {
			$term_id 	= $term->term_id;
			$term_meta  = get_option( "taxonomy_" . $term_id );
			if( isset($term_meta['dqfwc_quantity']) && !empty( $term_meta['dqfwc_quantity'] ) ){
				$args['min_value']   = (int) $term_meta['dqfwc_quantity'];
				$args['input_value'] = (int) $term_meta['dqfwc_quantity'];
			}
		}

		// Individual product default quantity
		$dqfwc_quantity 	 = get_post_meta( $product->get_id(), 'dqfwc_default_quantity', true );
		if( ! empty( $dqfwc_quantity ) ) {
			$args['min_value']   = (int) $dqfwc_quantity;
			$args['input_value'] = (int) $dqfwc_quantity;
		}
		
		return $args;
	}

}
