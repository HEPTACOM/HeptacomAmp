<?php declare(strict_types=1);

class Shopware_Controllers_Widgets_HeptacomAmpListing extends Shopware_Controllers_Widgets_Listing
{
    public function topSellerAction()
    {
        $this->View()->loadTemplate(implode(DIRECTORY_SEPARATOR, ['widgets', 'plugins', 'heptacom_amp', 'listing', 'top_seller.tpl']));

        parent::topSellerAction();
    }
}
