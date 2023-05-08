<?php

namespace Mak\DefaultQuantityForWoocommerce;
use Mak\DefaultQuantityForWoocommerce\Frontend\Storefront;

/**
 * Frontend handler class
 */
class Frontend {

    /**
     * Initialize the class
     */
    function __construct() {
        Storefront::instance()->init();
    }
}
