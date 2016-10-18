<?php

/**
 * Frontend controller
 */
class Shopware_Controllers_Frontend_HeptacomAmpDetail extends Shopware_Controllers_Frontend_Detail
{
    public function indexAction()
    {
        parent::indexAction();

        $this->View()->setTemplateDir(
            array(
                Shopware()->DocPath() . '/themes/Frontend/Bare',
                Shopware()->DocPath() . '/themes/Frontend/Responsive',
                __DIR__ . '/../../Views'
            )
        );
        $template = $this->View()->createTemplate('frontend/heptacom_amp/index.tpl');
        $this->View()->setTemplate($template);
    }
}
