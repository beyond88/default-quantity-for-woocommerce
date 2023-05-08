<?php

namespace Mak\DefaultQuantityForWoocommerce;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
    }

    /**
     * Add time and version on DB
     */
    public function add_version() {
        $installed = get_option( 'dqfwc_installed' );

        if ( ! $installed ) {
            update_option( 'dqfwc_installed', time() );
        }

        update_option( 'dqfwc_version', DQFWC_VERSION );
    }

}
