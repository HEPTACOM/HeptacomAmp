<?php

namespace HeptacomAmp\Subscriber;

use Enlight_Controller_Action;
use Enlight_Controller_Plugins_ViewRenderer_Bootstrap;
use Enlight_Event_EventArgs;
use Enlight\Event\SubscriberInterface;
use Enlight_Template_Manager;
use Enlight_View_Default;
use HeptacomAmp\Components\DOMAmplifier;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;
use HeptacomAmp\Components\FileCache;
use HeptacomAmp\Factory\ConfigurationFactory;
use HeptacomAmp\Reader\ConfigurationReader;
use HeptacomAmp\Services\Smarty\BlockAnnotator;
use HeptacomAmp\Struct\ConfigurationStruct;
use HeptacomAmp\Template\HeptacomAmp as HeptacomAmpTemplate;
use Shopware\Components\Logger;
use Shopware\Components\Theme\LessDefinition;
use Shopware_Components_Config;

/**
 * Class AMP
 * @package HeptacomAmp\Subscriber
 */
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
            'Enlight_Controller_Action_PreDispatch_Widgets' => 'injectRawTemplate',
        ];
        if (extension_loaded('dom')) {
            $listeners['Enlight_Plugins_ViewRenderer_FilterRender'] = 'filterRenderedView';
        }
        return $listeners;
    }

    /**
     * @var bool
     */
    private $templateDirConfigured = false;

    /**
     * @var Logger
     */
    private $pluginLogger;

    /**
     * @var FileCache
     */
    private $fileCache;

    /**
     * @var string
     */
    private $viewDirectory;

    /**
     * @var ConfigurationFactory
     */
    private $configurationFactory;

    /**
     * @var ConfigurationReader
     */
    private $configurationReader;

    /**
     * @var Shopware_Components_Config
     */
    private $config;

    /**
     * @var BlockAnnotator
     */
    private $blockAnnotator;

    /**
     * Detail constructor.
     * @param Logger $pluginLogger
     * @param FileCache $fileCache
     * @param string $viewDirectory
     * @param ConfigurationFactory $configurationFactory
     * @param ConfigurationReader $configurationReader
     * @param Shopware_Components_Config $config
     * @param BlockAnnotator $blockAnnotator
     */
    public function __construct(
        Logger $pluginLogger,
        FileCache $fileCache,
        $viewDirectory,
        ConfigurationFactory $configurationFactory,
        ConfigurationReader $configurationReader,
        Shopware_Components_Config $config,
        BlockAnnotator $blockAnnotator
    ) {
        $this->pluginLogger = $pluginLogger;
        $this->fileCache = $fileCache;
        $this->viewDirectory = $viewDirectory;
        $this->configurationFactory = $configurationFactory;
        $this->configurationReader = $configurationReader;
        $this->config = $config;
        $this->blockAnnotator = $blockAnnotator;
    }

    /**
     * @param Enlight_Event_EventArgs $args
     * @return LessDefinition
     */
    public function addLessFiles(Enlight_Event_EventArgs $args)
    {
        return new LessDefinition([], [implode(DIRECTORY_SEPARATOR, [
            $this->viewDirectory,
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

        $ampConfiguration = $this->configurationFactory->hydrate($this->configurationReader->read(Shopware()->Shop()->getId()));

        $frontendThemeDirectory = Shopware()->DocPath('themes'.DIRECTORY_SEPARATOR.'Frontend');

        $templateDirs = [
            $frontendThemeDirectory.'Bare',
            $frontendThemeDirectory.'Responsive',
            $this->viewDirectory,
        ];

        if (!empty($ampConfiguration->getTheme())) {
            $templateDirs[] = $frontendThemeDirectory.$ampConfiguration->getTheme();
        }

        $controller->View()->Engine()->template_class = HeptacomAmpTemplate::class;
        $controller->View()->setTemplateDir(array_filter($templateDirs, 'file_exists'));

        $controller->View()->Engine()->addPluginsDir(realpath(
            implode(DIRECTORY_SEPARATOR, [$this->viewDirectory, 'frontend', '_private', 'smarty'])
        ));

        $controller->Response()->setHeader('Access-Control-Allow-Origin', '*');

        if (self::shouldOutputDebugView($controller, $ampConfiguration)) {
            $this->showSmartyDebugBlocks($controller->View());
        }
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function injectRawTemplate(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $ampConfiguration = $this->configurationFactory->hydrate($this->configurationReader->read(Shopware()->Shop()->getId()));

        if (self::shouldOutputDebugView($controller, $ampConfiguration)) {
            $this->showSmartyDebugBlocks($controller->View());
        }
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

        $ampConfiguration = $this->configurationFactory->hydrate($this->configurationReader->read(Shopware()->Shop()->getId()));

        if (self::shouldOutputDebugView($bootstrap, $ampConfiguration)) {
            return;
        }

        try {
            $domAmplifier = new DOMAmplifier($this->fileCache);
            $styleStorage = new DOMAmplifier\StyleStorage();
            $styleInjector = new AmplifyDOM\CustomStyleInjector($styleStorage, $this->fileCache);
            $styleInjector->useAmplifier(new AmplifyStyle\RemoveImports());
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
            $styleInjector->useAmplifier(new AmplifyStyle\RemoveForbiddenAtRules());
            $domAmplifier->useAmplifier(new AmplifyDOM\StyleExtractor($styleStorage));
            $domAmplifier->useAmplifier(new AmplifyDOM\ReferencedStylesheetExtractor($styleStorage));
            $domAmplifier->useAmplifier(new AmplifyDOM\InlineStyleExtractor($styleStorage));
            $domAmplifier->useAmplifier(new AmplifyDOM\FontTagAsStyleExtractor($styleStorage));
            $domAmplifier->useAmplifier(new AmplifyDOM\ConvertIframeToYoutube());
            $domAmplifier->useAmplifier(new AmplifyDOM\TagFilter());
            $domAmplifier->useAmplifier(new AmplifyDOM\AttributeFilter());
            $domAmplifier->useAmplifier($styleInjector);
            $domAmplifier->useAmplifier(new AmplifyDOM\ComponentInjection());


            $args->setReturn($domAmplifier->amplifyHTML($args->getReturn()));
        } catch (\Exception $ex) {
            $this->pluginLogger->error('Error while amplifying output', [$ex]);
        }
    }

    /**
     * @param Enlight_Controller_Action|Enlight_Controller_Plugins_ViewRenderer_Bootstrap $controller
     * @param ConfigurationStruct $configuration
     * @return bool
     */
    protected static function shouldOutputDebugView($controller, ConfigurationStruct $configuration)
    {
        return $configuration->isDebug() && $controller->Front()->Request()->has('kskAmpRaw');
    }

    /**
     * @param Enlight_View_Default $view
     */
    protected function showSmartyDebugBlocks(Enlight_View_Default $view)
    {
        // set own caching dirs
        $this->reconfigureTemplateDirs($view->Engine());

        // configure shopware to not strip HTML comments
        $this->config->offsetSet('sSEOREMOVECOMMENTS', false);
        $view->Engine()->registerFilter('pre', array($this->blockAnnotator, 'annotate'));
    }

    /**
     * Set own template directory.
     *
     * @param $templateManager
     */
    protected function reconfigureTemplateDirs(Enlight_Template_Manager $templateManager)
    {
        if (!$this->templateDirConfigured) {
            $compileDir = $templateManager->getCompileDir() . 'blocks/';
            $cacheDir = $templateManager->getCacheDir() . 'blocks/';
            $templateManager->setCompileDir($compileDir);
            $templateManager->setCacheDir($cacheDir);
            $this->templateDirConfigured = true;
        }
    }
}
