<?php

use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Frontend_AmpCheckout extends Shopware_Controllers_Frontend_Checkout implements CSRFWhitelistAware
{
    /**
     * Returns a list with actions which should not be validated for CSRF protection
     *
     * @return string[]
     */
    public function getWhitelistedCSRFActions()
    {
        return array(
            'addArticle',
            'cart'
        );
    }
}
