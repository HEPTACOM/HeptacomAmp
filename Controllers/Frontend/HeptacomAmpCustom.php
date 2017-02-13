<?php

class Shopware_Controllers_Frontend_HeptacomAmpCustom extends Shopware_Controllers_Frontend_Custom
{
    public function indexAction()
    {
        $this->View()->loadTemplate(implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'custom', 'index.tpl']));

        parent::indexAction();
    }
}
