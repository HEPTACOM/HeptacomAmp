<?php

namespace HeptacomAmp\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;
use HeptacomAmp\Commands;
use HeptacomAmp\Components\CacheWarmer;

/**
 * Class Cli
 * @package HeptacomAmp\Subscriber
 */
class Cli implements SubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Console_Add_Command' => 'onAddConsoleCommand',
            'Shopware_CronJob_HeptacomAmpCronjobCacheWarmer' => 'cacheWarmer',
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function cacheWarmer(Enlight_Event_EventArgs $args)
    {
        /** @var CacheWarmer $cacheWarmer */
        $cacheWarmer = Shopware()->Container()->get('heptacom_amp.components.cache_warmer');

        $cacheWarmer->warmUp();
    }

    /**
     * @param Enlight_Event_EventArgs $args
     * @return ArrayCollection
     */
    public function onAddConsoleCommand(Enlight_Event_EventArgs $args)
    {
        return new ArrayCollection([
            new Commands\CacheWarmer(),
        ]);
    }
}
