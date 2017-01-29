<?php

use HeptacomAmp\Components\PluginDependencies;
use Shopware\Components\CSRFWhitelistAware;
use Shopware\Models\Article\Detail;

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
            'index',
            'dependencies',
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
     * @return Detail/Repository
     */
    private function getArticleDetailsRepository()
    {
        return $this->container->get('models')->getRepository(Detail::class);
    }

    /**
     * Callable via /backend/HeptacomAmpOverview/index
     */
    public function indexAction()
    {
        $this->indexActionTabSystem();
        $this->indexActionTabValidator();
    }

    private function indexActionTabSystem()
    {
        $this->View()->assign('tabSystemDependencies', PluginDependencies::instance()->getDependencies());
    }

    private function indexActionTabValidator()
    {
        $this->View()->assign('tabValidatorArticleDetails', $this->getArticleDetailsRepository()->findBy([]));
    }
}
