<?php

namespace Mak\DefaultQuantityForWoocommerce;

/**
 * Installer class.
 */
class Installer {

	/**
	 * Run the installer.
	 *
	 * @return void
	 */
	public function run(): void {
		$this->add_version();
	}

	/**
	 * Add time and version on DB.
	 *
	 * @return void
	 */
	public function add_version(): void {
		$installed = get_option( 'dqfwc_installed' );

		if ( ! $installed ) {
			update_option( 'dqfwc_installed', time() );
		}

		update_option( 'dqfwc_version', DQFWC_VERSION );
	}

}
