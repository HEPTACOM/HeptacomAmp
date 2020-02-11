<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use Closure;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\Helper\DOMNodeRecursiveIterator;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;

class AttributeFilter implements IAmplifyDOM
{
    /**
     * @var string[]
     */
    private static $ampDefaultAttributes = [
        'fallback',
        'heights',
        'layout',
        'media',
        'noloading',
        'on',
        'placeholder',
        'sizes',
        'width',
        'height',
    ];

    /**
     * @var Closure[]
     */
    private static $whitelist;

    /**
     * @var Closure[]
     */
    private static $blacklist;

    /**
     * Process and ⚡lifies the given node.
     *
     * @param DOMNode $node the node to ⚡lify
     *
     * @return DOMNode the ⚡lified node
     */
    public function amplify(DOMNode $node)
    {
        $nodes = new DOMNodeRecursiveIterator($node->childNodes);

        foreach ($nodes->getRecursiveIterator() as $subnode) {
            if ($subnode->hasAttributes() && $subnode instanceof DOMElement) {
                $removables = [];

                foreach ($subnode->attributes as $attribute) {
                    if (static::filterAttribute($attribute)) {
                        $removables[] = $attribute->nodeName;
                    }
                }

                foreach ($removables as $removable) {
                    $subnode->removeAttribute($removable);
                }
            }
        }

        return $node;
    }

    /**
     * @return Closure[]
     */
    private static function getWhitelist()
    {
        if (empty(static::$whitelist)) {
            static::$whitelist = [
            ];
        }

        return static::$whitelist;
    }

    /**
     * @return Closure[]
     */
    private static function getBlacklist()
    {
        if (empty(static::$blacklist)) {
            static::$blacklist = [
                /**
                 * Forbids on-events (but not on itself), xml-stuff.
                 *
                 * @param DOMNode $node the attribute to validate
                 *
                 * @return bool true, if the attribute is blacklisted by this rule, otherwise false
                 */
                function (DOMNode $node) {
                    return (stripos($node->nodeName, 'on') === 0 && strlen($node->nodeName) > 2) || stripos($node->nodeName, 'xml') === 0;
                },

                /**
                 * Forbids anchor javascript.
                 *
                 * @param DOMNode $node the attribute to validate
                 *
                 * @return bool true, if the attribute is blacklisted by this rule, otherwise false
                 */
                function (DOMNode $node) {
                    if (strtolower($node->parentNode->nodeName) == 'a' && strtolower($node->nodeName) == 'href') {
                        return stripos($node->textContent, 'javascript:') !== false;
                    }

                    return false;
                },

                /**
                 * Forbids anchor javascript.
                 *
                 * @param DOMNode $node the attribute to validate
                 *
                 * @return bool true, if the attribute is blacklisted by this rule, otherwise false
                 */
                function (DOMNode $node) {
                    if (strtolower($node->parentNode->nodeName) == 'a' && strtolower($node->nodeName) == 'target') {
                        return $node->textContent != '_blank';
                    }

                    return false;
                },

                /**
                 * Forbids forwarding via meta[http-equiv].
                 *
                 * @param DOMNode $node the node to validate
                 *
                 * @return bool true, if the node is blacklisted by this rule, otherwise false
                 */
                function (DOMNode $node) {
                    return strtolower($node->parentNode->nodeName) == 'meta' && strtolower($node->nodeName) == 'http-equiv';
                },

                /**
                 * Forbids wrong tags on amp-image.
                 *
                 * @param DOMNode $node the node to validate
                 *
                 * @return bool true, if the node is blacklisted by this rule, otherwise false
                 */
                function (DOMNode $node) {
                    if (strtolower($node->parentNode->nodeName) == 'amp-img') {
                        return !in_array(strtolower($node->nodeName), array_merge([
                            'src',
                            'srcset',
                            'alt',
                            'attribution',
                            'height',
                            'width',
                        ], static::$ampDefaultAttributes));
                    }

                    return false;
                },
            ];
        }

        return static::$blacklist;
    }

    /**
     * Validates the attribute against the whitelist and blacklist.
     *
     * @return bool true, if the node has to be removed, otherwise false
     */
    private static function filterAttribute(DOMNode $attribute)
    {
        foreach (static::getWhitelist() as $white) {
            if ($white($attribute)) {
                return false;
            }
        }
        foreach (static::getBlacklist() as $black) {
            if ($black($attribute)) {
                return true;
            }
        }

        return false;
    }
}
