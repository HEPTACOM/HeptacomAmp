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
            'dependencies',
            'index',
            'validator',
        ];
    }

    /**
     * Initialized on each action call.
     */
    public function preDispatch()
    {
        $this->get('template')->addTemplateDir(join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'Resources' , 'views']));
    }

    /**
     * Callable via /backend/HeptacomAmpOverview/validator
     */
    public function validatorAction()
    {
    }

    /**
     * Callable via /backend/HeptacomAmpOverview/dependencies
     */
    public function dependenciesAction()
    {
        $this->View()->assign('dependencies', PluginDependencies::instance()->getDependencies());
    }

    /**
     * Callable via /backend/HeptacomAmpOverview/index
     */
    public function indexAction()
    {
        $this->View()->assign('urls', ['empty' => 'url']);
    }
}
