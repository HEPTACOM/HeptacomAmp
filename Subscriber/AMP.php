<?php

namespace HeptacomAmp\Subscriber;

use Enlight_Controller_Action;
use Enlight_Controller_Plugins_ViewRenderer_Bootstrap;
use Enlight_Event_EventArgs;
use Enlight\Event\SubscriberInterface;
use HeptacomAmp\Components\DOMAmplifier;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;
use HeptacomAmp\Components\FileCache;
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

            'Enlight_Controller_Action_PreDispatch_Frontend_HeptacomAmpDetail' => 'injectAmpTemplate',
            'Enlight_Controller_Action_PreDispatch_Frontend_HeptacomAmpCustom' => 'injectAmpTemplate',
            'Enlight_Controller_Action_PreDispatch_Frontend_HeptacomAmpListing' => 'injectAmpTemplate',
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
     * @var FileCache
     */
    private $fileCache;

    /**
     * Detail constructor.
     * @param Logger $pluginLogger
     * @param FileCache $fileCache
     */
    public function __construct(Logger $pluginLogger, FileCache $fileCache)
    {
        $this->pluginLogger = $pluginLogger;
        $this->fileCache = $fileCache;
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
    public function injectAmpTemplate(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Action $controller */
        $controller = $args->get('subject');

        $controller->View()->Engine()->addPluginsDir(realpath(
            implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Resources', 'views', 'frontend', '_private', 'smarty'])
        ));

        $controller->View()->Engine()->template_class = 'HeptacomAmp\\Template\\HeptacomAmp';

        $controller->View()->setTemplateDir([
            implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'themes', 'Frontend', 'Bare']),
            implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'themes', 'Frontend', 'Responsive']),
            realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Resources', 'views'])),
        ]);
        if (file_exists(implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'themes', 'Frontend', 'HeptacomAmp']))) {
            $controller->View()->addTemplateDir(
                implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'themes', 'Frontend', 'HeptacomAmp'])
            );
        }

        $controller->Response()->setHeader('Access-Control-Allow-Origin', '*');
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
        if ($moduleName != 'frontend'
            || stripos($controllerName, 'heptacomAmp') !== 0
            || $args->get('template') !== null
            && stripos($args->get('template')->template_resource, 'frontend/plugins/heptacom_amp/') !== 0) {
            return;
        }

        try {
            $domAmplifier = new DOMAmplifier($this->fileCache);
            $styleStorage = new DOMAmplifier\StyleStorage();
            $styleInjector = new AmplifyDOM\CustomStyleInjector($styleStorage, $this->fileCache);
            $styleInjector->useAmplifier(new AmplifyStyle\RemoveKeyFrames());
            $styleInjector->useAmplifier(new AmplifyStyle\RemoveResponsiveMediaRules());
            $styleInjector->useAmplifier(new AmplifyStyle\RemoveVendorPrefixedItems());
            $styleInjector->useAmplifier(new AmplifyStyle\RemoveDuplicateValues());
            $styleInjector->useAmplifier(new AmplifyStyle\RemoveUnusedTagSelectors());
            $styleInjector->useAmplifier(new AmplifyStyle\HtmlEntitiesToUnicodeNotation());
            $styleInjector->useAmplifier(new AmplifyStyle\NoRuleIsImportant());
            $styleInjector->useAmplifier(new AmplifyStyle\RedirectUrls());
            // TODO revert commit bb66496a2772525a4e8e93c22c07cb376c09b80b to add class renaming
            $styleInjector->useAmplifier(new AmplifyStyle\RemoveUnitsOnNullValues());
            $styleInjector->useAmplifier(new AmplifyStyle\ShortenRulesToKnownShorthands());
            $styleInjector->useAmplifier(new AmplifyStyle\RenameFontWeightUnits());
            $styleInjector->useAmplifier(new AmplifyStyle\RemoveMicrosoftAtRules());
            $domAmplifier->useAmplifier(new AmplifyDOM\StyleExtractor($styleStorage));
            $domAmplifier->useAmplifier(new AmplifyDOM\ReferencedStylesheetExtractor($styleStorage));
            $domAmplifier->useAmplifier(new AmplifyDOM\InlineStyleExtractor($styleStorage));
            $domAmplifier->useAmplifier(new AmplifyDOM\FontTagAsStyleExtractor($styleStorage));
            $domAmplifier->useAmplifier(new AmplifyDOM\TagFilter());
            $domAmplifier->useAmplifier(new AmplifyDOM\AttributeFilter());
            $domAmplifier->useAmplifier($styleInjector);
            $domAmplifier->useAmplifier(new AmplifyDOM\ComponentInjection());


            $args->setReturn($domAmplifier->amplifyHTML($args->getReturn()));
        } catch (\Exception $ex) {
            $this->pluginLogger->error('Error while amplifying output', [$ex]);
        }
    }
}
