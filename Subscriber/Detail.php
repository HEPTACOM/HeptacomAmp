<?php

namespace Shopware\HeptacomAmp\Subscriber;

use Enlight\Event\SubscriberInterface;

class Detail implements SubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onFrontendDetailPostDispatch',
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_HeptacomAmpDetail' => 'onGetControllerPathFrontend',
        );
    }

    public function onFrontendDetailPostDispatch(\Enlight_Event_EventArgs $args)
    {
        $request = $args->getRequest();
        $controller = $args->getSubject();
        $view = $controller->View();

        $view->addTemplateDir(__DIR__ . '/../Views');
    }

    public function onGetControllerPathFrontend(\Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Frontend/HeptacomAmpDetail.php';
    }
}
