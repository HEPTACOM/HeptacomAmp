<?php

/**
 * Frontend controller
 */
class Shopware_Controllers_Frontend_HeptacomAmpDetail extends Shopware_Controllers_Frontend_Detail
{
    public function indexAction()
    {
        parent::indexAction();

        $this->View()->addTemplateDir(__DIR__ . '/../../Views');
        $template = $this->View()->createTemplate('frontend/heptacom_amp/index.tpl');
        $this->View()->setTemplate($template);
    }
}
