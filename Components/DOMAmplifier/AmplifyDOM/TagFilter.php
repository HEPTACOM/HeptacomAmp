<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;

/**
 * Class TagFilter
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
class TagFilter implements IAmplifyDOM
{
    /**
     * @var array
     */
    private static $whitelist;

    /**
     * @param DOMNode $node
     */
    private static function hasChildNode(DOMNode &$node)
    {
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
    }

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
                        "html",
                        "head",
                        "title",
                        "link",
                        "meta",
                        "style",
                        "body",
                        "article",
                        "section",
                        "nav",
                        "aside",
                        "h1", "h2", "h3", "h4", "h5", "h6",
                        "header",
                        "footer",
                        "address",
                        "p",
                        "hr",
                        "pre",
                        "blockquote",
                        "ol",
                        "ul",
                        "li",
                        "dl",
                        "dt",
                        "dd",
                        "figure",
                        "figcaption",
                        "div",
                        "main",
                        "a",
                        "em",
                        "strong",
                        "small",
                        "s",
                        "cite",
                        "q",
                        "dfn",
                        "abbr",
                        "data",
                        "time",
                        "code",
                        "var",
                        "samp",
                        "kbd",
                        "sub",
                        "sup",
                        "i",
                        "b",
                        "u",
                        "mark",
                        "ruby",
                        "rb",
                        "rt",
                        "rtc",
                        "rp",
                        "bdi",
                        "bdo",
                        "span",
                        "br",
                        "wbr",
                        "ins",
                        "del",
                        "svg",
                        "g",
                        "path",
                        "glyph",
                        "glyphref",
                        "marker",
                        "view",
                        "circle",
                        "line",
                        "polygon",
                        "polyline",
                        "rect",
                        "text",
                        "textpath",
                        "tref",
                        "tspan",
                        "clippath",
                        "filter",
                        "lineargradient",
                        "radialgradient",
                        "mask",
                        "pattern",
                        "vkern",
                        "hkern",
                        "defs",
                        "use",
                        "symbol",
                        "desc",
                        "title",
                        "table",
                        "caption",
                        "colgroup",
                        "col",
                        "tbody",
                        "thead",
                        "tfoot",
                        "tr",
                        "td",
                        "th",
                        "button",
                        "noscript",
                        "acronym",
                        "center",
                        "dir",
                        "hgroup",
                        "listing",
                        "multicol",
                        "nextid",
                        "nobr",
                        "spacer",
                        "strike",
                        "tt",
                        "xmp",
                        "amp-img",
                        "amp-video",
                        "amp-ad",
                        "amp-fit-text",
                        "amp-font",
                        "amp-carousel",
                        "amp-anim",
                        "amp-youtube",
                        "amp-twitter",
                        "amp-vine",
                        "amp-instagram",
                        "amp-iframe",
                        "amp-pixel",
                        "amp-audio",
                        "amp-lightbox",
                        "amp-image-lightbox",
                        "amp-accordion",
                        "amp-sidebar",

                        // not in HTML5 Whitelist
                        /* manuell */
                        "#text",
                        "textarea",
                        "form",
                        "input",
                        "option",
                        "select",
                        /* manuell */

                        // has special whitelist
                        // "script",
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
                            (stripos($node->getAttribute('href'), '//use.typekit.net/') !== false) ||
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
     * Validates the given node and its children against the whitelist and blacklist.
     * @param DOMNode $node The node to validate.
     * @return bool True, if the node is valid, otherwise false.
     */
    private static function filterNode(DOMNode $node)
    {
        foreach (static::getWhitelist() as $white) {
            if ($white($node)) {
                self::hasChildNode($node);
                return true;
            }
        }
        return false;
    }

    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    public function amplify(DOMNode $node)
    {
        static::filterNode($node instanceof DOMDocument ? $node->lastChild : $node);
        return $node;
    }
}
