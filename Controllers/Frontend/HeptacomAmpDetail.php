<?php declare(strict_types=1);

class Shopware_Controllers_Frontend_HeptacomAmpDetail extends Shopware_Controllers_Frontend_Detail
{
    public function preDispatch()
    {
        if ($this->Request()->getParam('heptacom_amp_redirect')) {
            if ($this->Request()->getActionName() == 'index') {
                $this->redirect([
                    'controller' => 'detail',
                    'action' => 'index',
                    'sArticle' => (int) $this->Request()->get('sArticle'),
                    'amp' => 1,
                ]);
            }
        }

        parent::preDispatch();
    }

    public function indexAction()
    {
        parent::indexAction();

        $templateName = implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'detail', 'index.tpl']);
        $template = $this->View()->Engine()->createTemplate($templateName, null, null, $this->View()->Template(), false);
        $this->View()->setTemplate($template);
    }

    public function errorAction()
    {
        parent::errorAction();

        $templateName = implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'detail', 'error.tpl']);
        $template = $this->View()->Engine()->createTemplate($templateName, null, null, $this->View()->Template(), false);
        $this->View()->setTemplate($template);
    }
}
