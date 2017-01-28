<?php

namespace HeptacomAmp\Subscriber;

use DOMDocument;
use DOMNode;
use Enlight_Controller_Action;
use Enlight_Controller_Plugins_ViewRenderer_Bootstrap;
use Enlight_Event_EventArgs;
use Enlight\Event\SubscriberInterface;
use Shopware\Components\Logger;

class Detail implements SubscriberInterface
{
    /**
     * @var array
     */
    private static $filterTagWhitelist;

    /**
     * @return array
     */
    private static function getFilterTagWhitelist() {
        if (empty(static::$filterTagWhitelist)) {
            static::$filterTagWhitelist = [
                function (DOMNode $node) {
                    return false;
                }
            ];
        }

        return static::$filterTagWhitelist;
    }

    /**
     * @var array
     */
    private static $filterTagBlacklist;

    /**
     * @return array
     */
    private static function getFilterTagBlacklist() {
        if (empty(static::$filterTagBlacklist)) {
            static::$filterTagBlacklist = [
                function (DOMNode $node) {
                    return false;
                }
            ];
        }

        return static::$filterTagBlacklist;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $listeners = [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onFrontendDetailPostDispatch',
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_HeptacomAmpDetail' => 'onGetControllerPathFrontendDetail',
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
     * Detail constructor.
     * @param Logger $pluginLogger
     */
    public function __construct(Logger $pluginLogger)
    {
        $this->pluginLogger = $pluginLogger;
    }

    /**
     * @param DOMDocument $document
     * @return DOMDocument
     */
    private function moveStyleAttributesToHead(DOMDocument $document)
    {
        $cssIndex = 0;
        $css = [];

        $styleExtractor = function(){};
        $styleExtractor = function (DOMNode $node) use (&$styleExtractor, &$cssIndex, &$css)
        {
            if ($node->hasAttributes() && !is_null($styleAttr = $node->attributes->getNamedItem("style"))) {
                $key = 'heptacom-amp-inline-'.++$cssIndex;
                $style = str_replace('!important', '', $styleAttr->nodeValue);
                $css[$cssIndex] = ".$key{ $style}";

                $node->removeAttribute("style");

                if ($node instanceof \DOMElement) {
                    $class = $node->getAttribute("class");
                    if (empty($class)) {
                        $node->setAttribute('class', $key);
                    } else {
                        $node->setAttribute('class', "$class $key");
                    }
                }
            }

            if ($node->hasChildNodes()) {
                foreach ($node->childNodes as $childNode) {
                    $styleExtractor($childNode);
                }
            }
        };

        $styleExtractor($document);

        foreach ($document->getElementsByTagName('style') as $style) {
            if (!is_null($style->attributes->getNamedItem('amp-custom'))) {
                $style->textContent .= join('', $css);
                break;
            }
        }

        return $document;
    }

    /**
     * @param DOMDocument $document
     * @return DOMDocument
     */
    private function removeTagsByRules(DOMDocument $document)
    {
        $filterAllNodes = function(){};
        $filterAllNodes = function (DOMNode $node) use (&$filterAllNodes)
        {
            foreach (static::getFilterTagWhitelist() as $white) {
                if ($white($node)) {
                    return true;
                }
            }

            foreach (static::getFilterTagBlacklist() as $black) {
                if ($black($node)) {
                    return false;
                }
            }

            if ($node->hasChildNodes()) {
                $removables = [];

                foreach ($node->childNodes as $childNode) {
                    if (!$filterAllNodes($childNode)) {
                        $removables[] = $childNode;
                    }
                }

                foreach ($removables as $childNode) {
                    $node->removeChild($childNode);
                }
            }

            return true;
        };

        $filterAllNodes($document);

        return $document;
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

        $html = $args->getReturn();
        /** @var DOMDocument $dom */
        $dom = Shopware()->Container()->get('heptacom_amp.dom_document');
        if (!$dom->loadHTML($html)) {
            $this->pluginLogger->error('Could not load AMP HTML');
            return;
        }

        $dom = $this->moveStyleAttributesToHead($dom);
        $dom = $this->removeTagsByRules($dom);

        if (!$parsed = $dom->saveHTML()) {
            $this->pluginLogger->error('Could not save AMP HTML');
            return;
        }

        $args->setReturn($parsed);
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onFrontendDetailPostDispatch(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $request = $controller->Request();
        $view = $controller->View();

        $view->addTemplateDir(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Resources', 'views']));

        if ($request->get('amp') == 1) {
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
    public function onGetControllerPathFrontendDetail(Enlight_Event_EventArgs $args)
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Controllers', 'Frontend', 'HeptacomAmpDetail.php']);
    }
}
