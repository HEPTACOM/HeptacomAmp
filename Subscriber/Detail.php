<?php

namespace Shopware\HeptacomAmp\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_Request_Request;
use Enlight_Event_EventArgs;
use Shopware_Controllers_Frontend_Detail;

class Detail implements SubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onFrontendDetailPostDispatch',
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_HeptacomAmpDetail' => 'onGetControllerPathFrontend',
        );
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onFrontendDetailPostDispatch(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Request_Request $request */
        $request = $args->get('request');
        /** @var Shopware_Controllers_Frontend_Detail $controller */
        $controller = $args->get('subject');
        $view = $controller->View();

        $view->addTemplateDir(__DIR__ . '/../Views');

        if ($request->getParam('amp') == 1) {
            $sArticle = (int) $request->get('sArticle');

            $controller->redirect([
                'controller' => 'heptacomAmpDetail',
                'action' => 'index',
                'sArticle' => $sArticle,
            ]);
        }
    }

    /**
     * @param Enlight_Event_EventArgs $args
     * @return string
     */
    public function onGetControllerPathFrontend(Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Frontend/HeptacomAmpDetail.php';
    }
}
