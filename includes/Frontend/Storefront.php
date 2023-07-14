<?php

namespace Mak\DefaultQuantityForWoocommerce\Frontend;

use Mak\DefaultQuantityForWoocommerce\Traits\Singleton;

/**
 * The storefront class.
 */
class Storefront {

	use Singleton;
	/**
	 * Load filters and actions to display default quantity.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	public function init(): void {
		add_filter( 'woocommerce_quantity_input_args', [ $this, 'dqfwc_quantity_input_args' ], PHP_INT_MAX, 2 );
	}

	/**
	 * Save default quantity meta value for individual products.
	 *
	 * @since   1.0.0
	 * @param   $args, $product WooCommerce quantity arguments and product object.
	 * @return  array
	 */
	public function dqfwc_quantity_input_args( $args, $product ): array {

		// Retrieve global default quanity.
		$dqfwc_global = get_option( 'woocommerce_default_quantity' );
		if ( ! empty( $dqfwc_global ) ) {
			$args['min_value']   = (int) $dqfwc_global;
			$args['input_value'] = (int) $dqfwc_global;
		}

		// Retrieve product category meta.
		$dqfwc_product_cats = wp_get_post_terms( $product->get_id(), 'product_cat' );
		foreach ( $dqfwc_product_cats as $term ) {
			$term_id   = $term->term_id;
			$term_meta = get_option( 'taxonomy_' . $term_id );
			if ( isset( $term_meta['dqfwc_quantity'] ) && ! empty( $term_meta['dqfwc_quantity'] ) ) {
				$args['min_value']   = (int) $term_meta['dqfwc_quantity'];
				$args['input_value'] = (int) $term_meta['dqfwc_quantity'];
			}
		}

		// Individual product default quantity.
		$dqfwc_quantity = get_post_meta( $product->get_id(), 'dqfwc_default_quantity', true );
		if ( ! empty( $dqfwc_quantity ) ) {
			$args['min_value']   = (int) $dqfwc_quantity;
			$args['input_value'] = (int) $dqfwc_quantity;
		}

		return $args;
	}

}
