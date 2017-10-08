<?php

class Shopware_Controllers_Frontend_HeptacomAmpListing extends Shopware_Controllers_Frontend_Listing
{
    public function indexAction()
    {
        parent::indexAction();

        $this->View()->loadTemplate(implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'listing', 'index.tpl']));
    }

    public function manufacturerAction()
    {
        parent::manufacturerAction();

        $this->View()->loadTemplate(implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'listing', 'manufacturer.tpl']));
    }
}
