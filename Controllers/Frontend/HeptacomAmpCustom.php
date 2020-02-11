<?php declare(strict_types=1);

class Shopware_Controllers_Frontend_HeptacomAmpCustom extends Shopware_Controllers_Frontend_Custom
{
    public function indexAction()
    {
        parent::indexAction();

        $templateName = implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'custom', 'index.tpl']);
        $template = $this->View()->Engine()->createTemplate($templateName, null, null, $this->View()->Template(), false);
        $this->View()->setTemplate($template);
    }
}
