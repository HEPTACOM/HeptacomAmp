<?php

namespace Shopware\HeptaDetailAmp\Subscriber;

use Enlight\Event\SubscriberInterface;

class Detail implements SubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onFrontendDetailPostDispatch',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_AmpCheckout' => 'onFrontendAmpCheckoutPostDispatch',
        );
    }

    public function onFrontendDetailPostDispatch(\Enlight_Event_EventArgs $args)
    {
        $request = $args->getRequest();
        $controller = $args->getSubject();
        $view = $controller->View();

        $view->addTemplateDir(__DIR__ . '/../Views');

        if ($request->getParam('amp') == 1) {
            $template = $view->createTemplate('frontend/detail-amp/index.tpl');
            $view->setTemplate($template);
        }
    }

    public function onFrontendAmpCheckoutPostDispatch(\Enlight_Event_EventArgs $args)
    {
        $request = $args->getRequest();
        $controller = $args->getSubject();
        $view = $controller->View();
        $action = $request->getActionName();

        $template = $view->createTemplate('frontend/checkout/' . $action . '.tpl');
        $view->setTemplate($template);
    }
}
