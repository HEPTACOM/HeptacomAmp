<?php

namespace HeptacomAmp\Subscriber;

use DOMDocument;
use DOMElement;
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
                /**
                 * Allows all these tags.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is whitelisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    return in_array(strtolower($node->nodeName), [
                        'amp-img',
                        'amp-video',
                        'amp-audio',
                        'amp-iframe',
                        'amp-form',
                        'svg'
                    ]);
                },

                /**
                 * Allows resource links for microformat schema rules.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is whitelisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    return strtolower($node->nodeName) == 'link' &&
                        $node->hasAttributes() &&
                        !is_null($attr = $node->getAttribute('href')) &&
                        stripos($attr, 'microformats.org/') !== false;
                },

                /**
                 * Allows resource links for fonts by various font providers.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is whitelisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    if (strtolower($node->nodeName) == 'link' &&
                        $node->hasAttributes() &&
                        $node->getAttribute('rel') === 'stylesheet') {

                        return (stripos($node->getAttribute('href'), '//fonts.googleapis.com/css?') !== false) ||
                               (stripos($node->getAttribute('href'), '//cloud.typography.com/') !== false) ||
                               (stripos($node->getAttribute('href'), '//fast.fonts.net/') !== false) ||
                               (stripos($node->getAttribute('href'), '//maxcdn.bootstrapcdn.com') !== false);
                    }

                    return false;
                },

                /**
                 * Allows all scripts that are tagged with a references to a custom-element.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is whitelisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    return strtolower($node->nodeName) == 'script' &&
                           $node->hasAttributes() &&
                           stripos($node->getAttribute('src', '//cdn.ampproject.org/')) !== false;
                },

                /**
                 * Allows all scripts that are either tagged with
                 * amp-custom, amp-boilerplate or references to a custom-element.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is whitelisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    if (strtolower($node->nodeName) == 'style' && $node->hasAttributes()) {
                        return !is_null($node->getAttributeNode('amp-boilerplate')) ||
                               !is_null($node->getAttributeNode('amp-custom'));
                    }

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
                /**
                 * Forbids all these tags.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is blacklisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    return in_array(strtolower($node->nodeName), [
                        'img',
                        'video',
                        'audio',
                        'iframe',
                        'script',
                        'style',
                        'base',
                        'frame',
                        'frameset',
                        'object',
                        'param',
                        'applet',
                        'embed'
                    ]);
                },

                /**
                 * Forbids style[amp-custom] with more than 50k bytes of content.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is blacklisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    return strtolower($node->nodeName) == 'style' &&
                        $node->hasAttributes() &&
                        !is_null($node->getAttributeNode('amp-custom')) &&
                        strlen($node->textContent) > 50000;
                },

                /**
                 * Forbids every input tag of type image, password, button or file.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is blacklisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    return strtolower($node->nodeName) == 'input' &&
                        $node->hasAttributes() &&
                        !is_null($attr = $node->getAttribute('type')) &&
                        in_array(strtolower($attr), [
                            'image',
                            'password',
                            'button',
                            'file'
                    ]);
                },

                /**
                 * Forbids links with external stylesheets.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is blacklisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    return strtolower($node->nodeName) == 'link' && in_array(strtolower($node->getAttribute('rel')), [
                        'stylesheet',
                        'preconnect',
                        'prefetch',
                        'preload',
                        'prerender'
                    ]);
                }
            ];
        }

        return static::$filterTagBlacklist;
    }

    /**
     * @var array
     */
    private static $filterAttributeWhitelist;

    /**
     * @return array
     */
    private static function getFilterAttributeWhitelist() {
        if (empty(static::$filterAttributeWhitelist)) {
            static::$filterAttributeWhitelist = [
            ];
        }

        return static::$filterAttributeWhitelist;
    }

    /**
     * @var array
     */
    private static $filterAttributeBlacklist;

    /**
     * @return array
     */
    private static function getFilterAttributeBlacklist() {
        if (empty(static::$filterAttributeBlacklist)) {
            static::$filterAttributeBlacklist = [
                /**
                 * Forbids on-events (but not on itself), xml-stuff.
                 * @param DOMNode $node The attribute to validate.
                 * @return boolean True, if the attribute is blacklisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    return (stripos($node->nodeName, 'on') === 0 && strlen($node->nodeName) > 2) || stripos($node->nodeName, 'xml') === 0;
                },

                /**
                 * Forbids anchor javascript.
                 * @param DOMNode $node The attribute to validate.
                 * @return boolean True, if the attribute is blacklisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    if (strtolower($node->parentNode->nodeName) == 'a' && strtolower($node->nodeName) == 'href') {
                        return stripos($node->textContent, 'javascript:') !== false;
                    }

                    return false;
                },

                /**
                 * Forbids anchor javascript.
                 * @param DOMNode $node The attribute to validate.
                 * @return boolean True, if the attribute is blacklisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    if (strtolower($node->parentNode->nodeName) == 'a' && strtolower($node->nodeName) == 'target') {
                        return $node->textContent != '_blank';
                    }

                    return false;
                },

                /**
                 * Forbids forwarding via meta[http-equiv].
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is blacklisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    return strtolower($node->parentNode->nodeName) == 'meta' && strtolower($node->nodeName) == 'http-equiv';
                }
            ];
        }

        return static::$filterAttributeBlacklist;
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


    /**
     * @param DOMDocument $document
     * @return DOMDocument
     */
    private function removeAttributesByRules(DOMDocument $document)
    {
        $removeTags = function (DOMNode $node)
        {
            foreach (static::getFilterAttributeWhitelist() as $white) {
                if ($white($node)) {
                    return false;
                }
            }
            foreach (static::getFilterAttributeBlacklist() as $black) {
                if ($black($node)) {
                    return true;
                }
            }

            return false;
        };

        $filterAllNodes = function(){};
        $filterAllNodes = function (DOMNode $node) use (&$filterAllNodes, $removeTags)
        {
            if ($node->hasAttributes() && $node instanceof DOMElement) {
                $removables = [];

                foreach ($node->attributes as $attribute) {
                    if ($removeTags($attribute)) {
                        $removables[] = $attribute->nodeName;
                    }
                }

                foreach ($removables as $removable) {
                    $node->removeAttribute($removable);
                }
            }

            if ($node->hasChildNodes()) {
                foreach ($node->childNodes as $childNode) {
                    $filterAllNodes($childNode);
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
        $dom = $this->removeAttributesByRules($dom);

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
