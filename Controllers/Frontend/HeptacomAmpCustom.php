<?php

class Shopware_Controllers_Frontend_HeptacomAmpCustom extends Shopware_Controllers_Frontend_Custom
{
    public function preDispatch()
    {
        parent::preDispatch();

        $this->View()->Engine()->addPluginsDir(realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'Resources', 'views', 'frontend', '_private', 'smarty'])));
    }

    public function indexAction()
    {
        $this->View()->Engine()->template_class = 'HeptacomAmp\\Template\\HeptacomAmp';
        $this->View()->loadTemplate(implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'heptacom_amp_custom', 'index.tpl']));

        $this->View()->setTemplateDir([
            implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'themes', 'Frontend', 'Bare']),
            implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'themes', 'Frontend', 'Responsive']),
            realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'Resources', 'views'])),
        ]);
        if (file_exists(implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'themes', 'Frontend', 'HeptacomAmp']))) {
            $this->View()->addTemplateDir(
                implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'themes', 'Frontend', 'HeptacomAmp'])
            );
        }

        parent::indexAction();
    }
}
