<?php

use HeptacomAmp\Components\PluginDependencies;
use Shopware\Components\CSRFWhitelistAware;

/**
 * Class Shopware_Controllers_Backend_KskAmpBackend
 */
class Shopware_Controllers_Backend_KskAmpBackend extends Shopware_Controllers_Api_Rest implements CSRFWhitelistAware
{
    /**
     * Returns a list with actions which should not be validated for CSRF protection
     *
     * @return string[]
     */
    public function getWhitelistedCSRFActions()
    {
        return [
            'getDependencies',
        ];
    }

    /**
     * @return array
     */
    private function getDependencies()
    {
        return PluginDependencies::instance()->getDependencies();
    }

    /**
     * Callable via /backend/KskAmpBackend/getDependencies
     */
    public function getDependenciesAction()
    {
        $this->View()->assign([
            'success' => false,
            'data' => $this->getDependencies(),
        ]);
    }
}