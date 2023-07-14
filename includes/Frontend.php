<?php

namespace Mak\DefaultQuantityForWoocommerce;

use Mak\DefaultQuantityForWoocommerce\Frontend\Storefront;

/**
 * Frontend handler class.
 */
class Frontend {

	/**
	 * Initialize the class.
	 */
	public function __construct() {
		Storefront::instance()->init();
	}
}
