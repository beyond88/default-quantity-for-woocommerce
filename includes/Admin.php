<?php

namespace Mak\DefaultQuantityForWoocommerce;

use Mak\DefaultQuantityForWoocommerce\Admin\Settings;

/**
 * The admin class.
 */
class Admin {

	/**
	 * Initialize the class.
	 */
	public function __construct() {
		Settings::instance()->init();
		new Admin\PluginMeta();
	}

	/**
	 * Dispatch and bind actions.
	 *
	 * @return void
	 */
	public function dispatch_actions( $main ) {

	}
}
