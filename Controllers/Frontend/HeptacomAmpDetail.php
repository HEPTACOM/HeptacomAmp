<?php

class Shopware_Controllers_Frontend_HeptacomAmpDetail extends Shopware_Controllers_Frontend_Detail
{
    public function preDispatch()
    {
        if ($this->Request()->getParam('heptacom_amp_redirect')) {
            if ($this->Request()->getActionName() == 'index') {
                $this->redirect([
                    'controller' => 'detail',
                    'action' => 'index',
                    'sArticle' => (int)$this->Request()->get('sArticle'),
                    'amp' => 1,
                ]);
            }
        }

        parent::preDispatch();
    }

    public function indexAction()
    {
        $this->View()->loadTemplate(implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'detail', 'index.tpl']));

        parent::indexAction();
    }
}
