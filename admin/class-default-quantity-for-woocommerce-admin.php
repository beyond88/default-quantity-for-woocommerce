<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.thenextwp.co
 * @since      1.0.0
 *
 * @package    Default_Quantity_For_Woocommerce
 * @subpackage Default_Quantity_For_Woocommerce/admin
 * @author     Mohiuddin Abdul Kader <muhin.cse.diu@gmail.com>
 */
class Default_Quantity_For_Woocommerce_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the default quantity settings for the products.
	 *
	 * @since   1.0.0
	 * @params 	array		
	 * @return 	void 
	*/	
	public function dqfwc_default_quantity_settings( $settings ) {

		$new_settings = array();
		foreach ( $settings as &$setting ) {

			$new_settings[] = $setting;
			if ( 'woocommerce_manage_stock' === $setting['id'] ) {
				$new_settings[] = array(
					'title'             => __( 'Global default quantity', 'woocommerce' ),
					'desc'              => __( 'Choose a default quantity for all your products. You can override this for individual categories/products', 'woocommerce' ),
					'id'                => 'woocommerce_default_quantity',
					'type'              => 'number',
					'custom_attributes' => array(
						'min'  => 0,
						'step' => 1,
					),
					'css'               => 'width: 80px;',
					'default'           => '1',
					'autoload'          => false,
					'class'             => 'manage_stock_field',
				); 
			}

		}

		return $new_settings; 	
	}

	/**
	 * Add product category meta.
	 *
	 * @since   1.0.0
	 * @params 	none		
	 * @return 	void 
	*/	
	public function dqfwc_taxonomy_add_new_meta_field() {

		?>

		<div class="form-field">
			<label for="term_meta[dqfwc_quantity]">
				<?php _e('Default quantity', 'default-quantity-for-woocommerce'); ?>
			</label>
			<input type="number" name="term_meta[dqfwc_quantity]" id="term_meta[dqfwc_quantity]" min="0" step="1">
			<p class="description">
				<?php _e('Enter default quantity', 'default-quantity-for-woocommerce'); ?>
			</p>
		</div>

		<?php

	}

	/**
	 * Edit product category meta.
	 *
	 * @since   1.0.0
	 * @params 	object		
	 * @return 	void 
	*/
	public function dqfwc_taxonomy_edit_meta_field( $term ) {

		$term_id 	= $term->term_id;
		$term_meta  = get_option( "taxonomy_" . $term_id );
		?>

		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="term_meta[dqfwc_quantity]">
					<?php _e('Default quantity', 'default-quantity-for-woocommerce'); ?>
				</label>
			</th>
			<td>
				<input type="number" name="term_meta[dqfwc_quantity]" id="term_meta[dqfwc_quantity]" min="0" step="1" value="<?php echo esc_attr($term_meta['dqfwc_quantity']) ? esc_attr($term_meta['dqfwc_quantity']) : ''; ?>">
				<p class="description">
					<?php _e('Enter default quantity', 'default-quantity-for-woocommerce'); ?>
				</p>
			</td>			
		</tr>

		<?php
	}

	/**
	 * Save product category meta value.
	 *
	 * @since   1.0.0
	 * @params 	int, POST		
	 * @return 	void 
	*/
	public function dqfwc_save_taxonomy_custom_meta( $term_id ) {
		
		if ( isset($_POST['term_meta']) ) {
			
			$term_meta = get_option("taxonomy_" . $term_id);
			$cat_keys = array_keys($_POST['term_meta']);
			
			foreach ($cat_keys as $key) {
				if ( isset( $_POST['term_meta'][$key] ) ) {
					$term_meta[$key] = sanitize_text_field( $_POST['term_meta'][$key] );
				}
			}
			
			update_option("taxonomy_" . $term_id, $term_meta);
		}
		
	}

	/**
	 * Add default quantity meta for individual products.
	 *
	 * @since   1.0.0
	 * @params 	none		
	 * @return 	void 
	*/	
	public function dqfwc_product_default_quantity_meta() {

		woocommerce_wp_text_input([
			'id' 	=> 'dqfwc_default_quantity',
			'label' => __('Default quantity', 'default-quantity-for-woocommerce'),
			'type'  => 'number',
			'custom_attributes' => array(
				'step' => '1',
				'min'  => '0'
			),			
		]);
		
	}	

	/**
	 * Save default quantity meta value for individual products.
	 *
	 * @since   1.0.0
	 * @params 	none		
	 * @return 	void 
	*/	
	public function dqfwc_save_product_default_quantity_meta( $post_id ) {
	
		$product = wc_get_product( $post_id );
		$product->update_meta_data( 'dqfwc_default_quantity', sanitize_text_field( $_POST['dqfwc_default_quantity'] ) );
		$product->save();

	}	

}
