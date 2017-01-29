<?php

namespace HeptacomAmp\Subscriber;

use Enlight\Event\SubscriberInterface;

class Backend implements SubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return  [
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_HeptacomAmpOverview' => 'onGetBackendOverviewController',
        ];
    }

    /**
     * @return string
     */
    public function onGetBackendOverviewController()
    {
        return join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Controllers', 'Backend', 'Overview.php']);
    }
}
