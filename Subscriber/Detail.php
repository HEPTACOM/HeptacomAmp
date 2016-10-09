<?php

namespace Shopware\HeptacomAmp\Subscriber;

use Enlight\Event\SubscriberInterface;

class Detail implements SubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onFrontendDetailPostDispatch',
        );
    }

    public function onFrontendDetailPostDispatch(\Enlight_Event_EventArgs $args)
    {
        $request = $args->getRequest();
        $controller = $args->getSubject();
        $view = $controller->View();

        $view->addTemplateDir(__DIR__ . '/../Views');

        if ($request->getParam('amp') == 1) {
            $template = $view->createTemplate('frontend/heptacom_amp/index.tpl');
            $view->setTemplate($template);
        }
    }
}
