<?php

namespace HeptacomAmp\Subscriber;

use Enlight_Controller_Plugins_ViewRenderer_Bootstrap;
use Enlight_Event_EventArgs;
use Enlight\Event\SubscriberInterface;
use HeptacomAmp\Components\DOMAmplifier;
use Shopware\Components\Logger;

class AMP implements SubscriberInterface
{
    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return extension_loaded('dom') ?
                ['Enlight_Plugins_ViewRenderer_FilterRender' => 'filterRenderedView']:
                [];
    }

    /**
     * @var Logger
     */
    private $pluginLogger;

    /**
     * @var DOMAmplifier
     */
    private $domAmplifier;

    /**
     * Detail constructor.
     * @param Logger $pluginLogger
     */
    public function __construct(Logger $pluginLogger)
    {
        $this->pluginLogger = $pluginLogger;

        $this->domAmplifier = new DOMAmplifier();
        $this->domAmplifier->useAmplifier(new DOMAmplifier\CSSMerge());
        $this->domAmplifier->useAmplifier(new DOMAmplifier\ComponentInjection());
        $this->domAmplifier->useAmplifier(new DOMAmplifier\TagFilter());
        $this->domAmplifier->useAmplifier(new DOMAmplifier\AttributeFilter());
    }

    public function filterRenderedView(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Plugins_ViewRenderer_Bootstrap $bootstrap */
        $bootstrap = $args->get('subject');
        $moduleName = $bootstrap->Front()->Request()->getModuleName();
        $controllerName = $bootstrap->Front()->Request()->getControllerName();
        if ($moduleName != 'frontend' || $controllerName != 'heptacomAmpDetail') {
            return;
        }

        try {
            $args->setReturn($this->domAmplifier->amplifyHTML($args->getReturn()));
        } catch (\Exception $ex) {
            $this->pluginLogger->error('Error while amplifying output', [$ex]);
        }
    }
}
