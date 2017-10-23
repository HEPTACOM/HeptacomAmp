<?php

class Shopware_Controllers_Frontend_HeptacomAmpListing extends Shopware_Controllers_Frontend_Listing
{
    public function indexAction()
    {
        parent::indexAction();

        $templateName = implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'listing', 'index.tpl']);
        $template = $this->View()->Engine()->createTemplate($templateName, null, null, $this->View()->Template(), false);
        $this->View()->setTemplate($template);
    }

    public function manufacturerAction()
    {
        parent::manufacturerAction();

        $templateName = implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'listing', 'manufacturer.tpl']);
        $template = $this->View()->Engine()->createTemplate($templateName, null, null, $this->View()->Template(), false);
        $this->View()->setTemplate($template);
    }
}
