<?php

namespace HeptacomAmp\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;
use HeptacomAmp\Commands;

class Cli implements SubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Console_Add_Command' => 'onAddConsoleCommand',
        ];
    }

    public function onAddConsoleCommand(Enlight_Event_EventArgs $args)
    {
        return new ArrayCollection([
            new Commands\CacheWarmer(),
        ]);
    }
}
