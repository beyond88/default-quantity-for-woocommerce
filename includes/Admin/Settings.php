<?php

namespace Mak\DefaultQuantityForWoocommerce\Admin;

use Mak\DefaultQuantityForWoocommerce\Traits\Singleton;

class Settings {

	/**
	 * Use singleton traits
	 */
	use Singleton;

	/** Bootstraps the class and hooks required actions & filters.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	public function init() {

		add_filter( 'woocommerce_inventory_settings', array( $this, 'dqfwc_default_quantity_settings' ) );
		add_action( 'product_cat_add_form_fields', array( $this, 'dqfwc_taxonomy_add_new_meta_field' ), PHP_INT_MAX, 2 );
		add_action( 'product_cat_edit_form_fields', array( $this, 'dqfwc_taxonomy_edit_meta_field' ), PHP_INT_MAX, 2 );
		add_action( 'edited_product_cat', array( $this, 'dqfwc_save_taxonomy_custom_meta' ), PHP_INT_MAX, 2 );
		add_action( 'create_product_cat', array( $this, 'dqfwc_save_taxonomy_custom_meta' ), PHP_INT_MAX, 2 );
		add_action( 'woocommerce_product_options_inventory_product_data', array( $this, 'dqfwc_product_default_quantity_meta' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'dqfwc_save_product_default_quantity_meta' ) );

	}

	/**
	 * Register the default quantity settings for the products.
	 *
	 * @since   1.0.0
	 * @param   array $settings Inventory settings array.
	 * @return  array
	 */
	public function dqfwc_default_quantity_settings( $settings ) : array {

		$new_settings = [];
		foreach ( $settings as &$setting ) {

			$new_settings[] = $setting;
			if ( 'woocommerce_manage_stock' === $setting['id'] ) {
				$new_settings[] = [
					'title'             => esc_html__( 'Global default quantity', 'default-quantity-for-woocommerce' ),
					'desc'              => esc_html__( 'Choose a default quantity for all your products. You can override this for individual categories/products', 'default-quantity-for-woocommerce' ),
					'id'                => 'woocommerce_default_quantity',
					'type'              => 'number',
					'custom_attributes' => [
						'min'  => 0,
						'step' => 1,
					],
					'css'               => 'width: 80px;',
					'default'           => '1',
					'autoload'          => false,
					'class'             => 'manage_stock_field',
				];
			}
		}

		return $new_settings;
	}

	/**
	 * Add product category meta.
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function dqfwc_taxonomy_add_new_meta_field(): void {

		?>

		<div class="form-field">
			<label for="term_meta[dqfwc_quantity]">
				<?php echo esc_html__( 'Default quantity', 'default-quantity-for-woocommerce' ); ?>
			</label>
			<input type="number" name="term_meta[dqfwc_quantity]" id="term_meta[dqfwc_quantity]" min="0" step="1">
			<p class="description">
				<?php echo esc_html__( 'Enter default quantity', 'default-quantity-for-woocommerce' ); ?>
			</p>
		</div>

		<?php

	}

	/**
	 * Edit product category meta.
	 *
	 * @since   1.0.0
	 * @param   object $term Term object.
	 * @return  void
	 */
	public function dqfwc_taxonomy_edit_meta_field( $term ): void {

		$term_id   = $term->term_id;
		$term_meta = get_option( 'taxonomy_' . $term_id );
		?>

		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="term_meta[dqfwc_quantity]">
					<?php echo esc_html__( 'Default quantity', 'default-quantity-for-woocommerce' ); ?>
				</label>
			</th>
			<td>
				<input type="number" name="term_meta[dqfwc_quantity]" id="term_meta[dqfwc_quantity]" min="0" step="1" value="<?php echo esc_attr( $term_meta['dqfwc_quantity'] ) ? esc_attr( $term_meta['dqfwc_quantity'] ) : ''; ?>">
				<p class="description">
					<?php echo esc_html__( 'Enter default quantity', 'default-quantity-for-woocommerce' ); ?>
				</p>
			</td>			
		</tr>

		<?php
	}

	/**
	 * Save product category meta value.
	 *
	 * @since   1.0.0
	 * @param   int $term_id Term id to update term meta.
	 * @return  void
	 */
	public function dqfwc_save_taxonomy_custom_meta( $term_id ): void {

		if ( isset( $_POST['term_meta'] ) ) {

			$term_meta = get_option( 'taxonomy_' . $term_id );
			$cat_keys  = array_keys( wp_unslash( $_POST['term_meta'] ) );

			foreach ( $cat_keys as $key ) {
				if ( isset( $_POST['term_meta'][ $key ] ) ) {
					$term_meta[ $key ] = sanitize_text_field( $_POST['term_meta'][ $key ] );
				}
			}

			update_option( 'taxonomy_' . $term_id, $term_meta );
		}

	}

	/**
	 * Add default quantity meta for individual products.
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function dqfwc_product_default_quantity_meta(): void {

		woocommerce_wp_text_input(
			[
				'id'                => 'dqfwc_default_quantity',
				'label'             => esc_html__( 'Default quantity', 'default-quantity-for-woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => [
					'step' => '1',
					'min'  => '1',
				],
			]
		);

	}

	/**
	 * Save default quantity meta value for individual products.
	 *
	 * @since   1.0.0
	 * @param   int $post_id
	 * @return  void
	 */
	public function dqfwc_save_product_default_quantity_meta( $post_id ): void {

		$product = wc_get_product( $post_id );
		if ( isset( $_POST['dqfwc_default_quantity'] ) ) {
			$product->update_meta_data( 'dqfwc_default_quantity', sanitize_text_field( $_POST['dqfwc_default_quantity'] ) );
			$product->save();
		}

	}

}
