<?php

class Shopware_Controllers_Frontend_HeptacomAmpListing extends Shopware_Controllers_Frontend_Listing
{
    public function indexAction()
    {
        $this->View()->loadTemplate(implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'listing', 'index.tpl']));

        parent::indexAction();
    }
}
