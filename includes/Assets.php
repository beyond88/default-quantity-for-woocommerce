<?php

namespace Mak\DefaultQuantityForWoocommerce;

/**
 * Assets handlers class.
 */
class Assets {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_assets' ) );
	}

	/**
	 * All available scripts.
	 *
	 * @return array
	 */
	public function get_scripts() {
		return array();
	}

	/**
	 * All available styles.
	 *
	 * @return array
	 */
	public function get_styles() {
		return array();
	}

	/**
	 * Register scripts and styles.
	 *
	 * @return void
	 */
	public function register_assets() {
		$scripts = $this->get_scripts();
		$styles  = $this->get_styles();

		foreach ( $scripts as $handle => $script ) {
			$deps = isset( $script['deps'] ) ? $script['deps'] : false;

			wp_enqueue_script( $handle, $script['src'], $deps, $script['version'], true );
		}

		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;

			wp_enqueue_style( $handle, $style['src'], $deps, $style['version'] );
		}

		wp_localize_script(
			'dqfwc-admin-script',
			'dqfwc',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'dqfwc-admin-nonce' ),
			)
		);
	}
}
