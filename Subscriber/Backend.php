<?php

namespace HeptacomAmp\Subscriber;

use Enlight\Event\SubscriberInterface;

/**
 * Class Backend
 * @package HeptacomAmp\Subscriber
 */
class Backend implements SubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return  [
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_KskAmpBackendApplication' => 'onGetKskAmpBackendApplicationController',
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_HeptacomAmpOverview' => 'onGetBackendOverviewController',
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_HeptacomAmpOverviewData' => 'onGetBackendOverviewDataController',
        ];
    }

    /**
     * @return string
     */
    public function onGetKskAmpBackendApplicationController()
    {
        return join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Controllers', 'Backend', 'KskAmpBackendApplication.php']);
    }

    /**
     * @return string
     */
    public function onGetBackendOverviewController()
    {
        return join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Controllers', 'Backend', 'Overview.php']);
    }

    /**
     * @return string
     */
    public function onGetBackendOverviewDataController()
    {
        return join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Controllers', 'Backend', 'OverviewData.php']);
    }
}
