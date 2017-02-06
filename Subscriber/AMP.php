<?php

namespace HeptacomAmp\Subscriber;

use Enlight_Controller_Plugins_ViewRenderer_Bootstrap;
use Enlight_Event_EventArgs;
use Enlight\Event\SubscriberInterface;
use HeptacomAmp\Components\DOMAmplifier;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;
use Shopware\Components\Logger;
use Shopware\Components\Theme\LessDefinition;

class AMP implements SubscriberInterface
{
    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        $listeners = [
            'Theme_Compiler_Collect_Plugin_Less' => 'addLessFiles',
        ];
        if (extension_loaded('dom')) {
            $listeners['Enlight_Plugins_ViewRenderer_FilterRender'] = 'filterRenderedView';
        }
        return $listeners;
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
        $styleStorage = new DOMAmplifier\StyleStorage();
        $styleInjector = new AmplifyDOM\CustomStyleInjector($styleStorage);
        $styleInjector->useAmplifier(new AmplifyStyle\RemoveFontsExceptShopware());
        $styleInjector->useAmplifier(new AmplifyStyle\RemoveKeyFrames());
        $styleInjector->useAmplifier(new AmplifyStyle\RemoveResponsiveMediaRules());
        $styleInjector->useAmplifier(new AmplifyStyle\RemoveVendorPrefixedItems());
        $styleInjector->useAmplifier(new AmplifyStyle\RemoveDuplicateValues());
        $styleInjector->useAmplifier(new AmplifyStyle\RemoveUnusedTagSelectors());
        $styleInjector->useAmplifier(new AmplifyStyle\HtmlEntitiesToUnicodeNotation());
        $styleInjector->useAmplifier(new AmplifyStyle\NoRuleIsImportant());
        $styleInjector->useAmplifier(new AmplifyStyle\RedirectUrls());
        $styleInjector->useAmplifier(new AmplifyStyle\RenameClassNames());
        $styleInjector->useAmplifier(new AmplifyStyle\RemoveUnitsOnNullValues());
        $styleInjector->useAmplifier(new AmplifyStyle\ShortenRulesToKnownShorthands());
        $this->domAmplifier->useAmplifier(new AmplifyDOM\StyleExtractor($styleStorage));
        $this->domAmplifier->useAmplifier(new AmplifyDOM\InlineStyleExtractor($styleStorage));
        $this->domAmplifier->useAmplifier(new AmplifyDOM\ReferencedStylesheetExtractor($styleStorage));
        $this->domAmplifier->useAmplifier(new AmplifyDOM\TagFilter());
        $this->domAmplifier->useAmplifier(new AmplifyDOM\AttributeFilter());
        $this->domAmplifier->useAmplifier($styleInjector);
        $this->domAmplifier->useAmplifier(new AmplifyDOM\ComponentInjection());
    }

    /**
     * @param Enlight_Event_EventArgs $args
     * @return LessDefinition
     */
    public function addLessFiles(Enlight_Event_EventArgs $args)
    {
        return new LessDefinition([], [implode(DIRECTORY_SEPARATOR, [
            __DIR__,
            '..',
            'Resources',
            'views',
            'frontend',
            '_public',
            'src',
            'less',
            'all.less'
        ])]);
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
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
