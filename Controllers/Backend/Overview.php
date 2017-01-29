<?php

use HeptacomAmp\Components\PluginDependencies;
use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Backend_HeptacomAmpOverview extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    /**
     * Returns a list with actions which should not be validated for CSRF protection
     *
     * @return string[]
     */
    public function getWhitelistedCSRFActions()
    {
        return [
        ];
    }

    /**
     * Initialized on each action call.
     */
    public function preDispatch()
    {
        $this->get('template')->addTemplateDir(join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'Resources' , 'views']));
    }
}
