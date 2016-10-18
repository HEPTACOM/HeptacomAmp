<?php

/**
 * Frontend controller
 */
class Shopware_Controllers_Frontend_HeptacomAmpDetail extends Shopware_Controllers_Frontend_Detail
{
    public function indexAction()
    {
        parent::indexAction();

        $this->View()->Engine()->template_class = 'Shopware\\HeptacomAmp\\Template\\HeptacomAmp';

        $this->View()->setTemplateDir(
            array(
                Shopware()->DocPath() . '/themes/Frontend/Bare',
                Shopware()->DocPath() . '/themes/Frontend/Responsive',
                __DIR__ . '/../../Views'
            )
        );
        $this->View()->loadTemplate('frontend/heptacom_amp/index.tpl');
    }
}
