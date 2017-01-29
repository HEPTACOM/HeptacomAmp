<?php

namespace HeptacomAmp\Components\DOMAmplifier;

use Closure;
use DOMElement;
use DOMNode;

/**
 * Class TagFilter
 * @package HeptacomAmp\Components\DOMAmplifier
 */
class TagFilter implements IAmplifyDOM
{
    /**
     * @var array
     */
    private static $whitelist;

    /**
     * @return array
     */
    private static function getWhitelist() {
        if (empty(static::$whitelist)) {
            static::$whitelist = [
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
                    $node instanceof DOMElement &&
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
                        $node instanceof DOMElement &&
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
                    $node instanceof DOMElement &&
                    stripos($node->getAttribute('src'), '//cdn.ampproject.org/') !== false;
                },

                /**
                 * Allows all scripts that are either tagged with
                 * amp-custom, amp-boilerplate or references to a custom-element.
                 * @param DOMNode $node The node to validate.
                 * @return boolean True, if the node is whitelisted by this rule, otherwise false.
                 */
                function (DOMNode $node) {
                    if (strtolower($node->nodeName) == 'style' &&
                        $node->hasAttributes() &&
                        $node instanceof DOMElement) {
                        return !is_null($node->getAttributeNode('amp-boilerplate')) ||
                        !is_null($node->getAttributeNode('amp-custom'));
                    }

                    return false;
                }
            ];
        }

        return static::$whitelist;
    }

    /**
     * @var Closure[]
     */
    private static $blacklist;

    /**
     * @return Closure[]
     */
    private static function getBlacklist() {
        if (empty(static::$blacklist)) {
            static::$blacklist = [
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
                    $node instanceof DOMElement &&
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
                    $node instanceof DOMElement &&
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
                    return strtolower($node->nodeName) == 'link' &&
                        $node instanceof DOMElement &&
                        in_array(strtolower($node->getAttribute('rel')), [
                            'stylesheet',
                            'preconnect',
                            'prefetch',
                            'preload',
                            'prerender'
                        ]);
                }
            ];
        }

        return static::$blacklist;
    }

    /**
     * Validates the given node and its children against the whitelist and blacklist.
     * @param DOMNode $node The node to validate.
     * @return bool True, if the node is valid, otherwise false.
     */
    private static function filterNode(DOMNode $node)
    {
        foreach (static::getWhitelist() as $white) {
            if ($white($node)) {
                return true;
            }
        }

        foreach (static::getBlacklist() as $black) {
            if ($black($node)) {
                return false;
            }
        }

        if ($node->hasChildNodes()) {
            $removables = [];

            foreach ($node->childNodes as $childNode) {
                if (!static::filterNode($childNode)) {
                    $removables[] = $childNode;
                }
            }

            foreach ($removables as $childNode) {
                $node->removeChild($childNode);
            }
        }

        return true;
    }

    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    public function amplify(DOMNode $node)
    {
        static::filterNode($node);
        return $node;
    }
}
