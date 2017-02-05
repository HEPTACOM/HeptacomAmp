<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use HeptacomAmp\Components\DOMAmplifier\Helper\DOMNodeRecursiveIterator;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Property\Selector;
use Sabberworm\CSS\RuleSet\DeclarationBlock;

/**
 * Class RemoveUnusedTagSelectors
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RemoveUnusedTagSelectors implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param DOMNode $domNode The node to ⚡lify.
     * @param Document $styleDocument The style to ⚡lify.
     * @return mixed The ⚡lified nodes.
     */
    function amplify(DOMNode $domNode, Document $styleDocument)
    {
        /** @var string[] $tags */
        $tags = [];
        /** @var string[] $classes */
        $classes = [];

        $nodes = new DOMNodeRecursiveIterator($domNode->childNodes);
        foreach ($nodes->getRecursiveIterator() as $subnode) {
            /** @var DOMNode $subnode */
            if (!in_array($subnode->nodeName, $tags)) {
                $tags[] = $subnode->nodeName;
            }

            if ($subnode instanceof DOMElement &&
                !empty($class = $subnode->getAttribute('class'))) {
                $classes = array_merge($classes, explode(' ', $class));
            }
        }

        $classes = array_filter($classes, 'strlen');

        foreach ($styleDocument->getAllDeclarationBlocks() as $declarationBlock) {
            /** @var DeclarationBlock $declarationBlock */
            /** @var Selector[] $selectorsToRemove */
            $selectorsToRemove = [];
            foreach ($declarationBlock->getSelectors() as $selector) {
                /** @var Selector $selector */

                if (!static::selectorContainsTag($selector, $tags) &&
                    !static::selectorContainsClass($selector, $classes) &&
                    !static::selectorContainsClassAttribute($selector, $classes)) {
                    $selectorsToRemove[] = $selector;
                }
            }

            if (count($selectorsToRemove) == count($declarationBlock->getSelectors())) {
                $styleDocument->remove($declarationBlock);
            } else {
                array_walk($selectorsToRemove, [$declarationBlock, 'removeSelector']);
            }
        }

        return [$domNode, $styleDocument];
    }

    /**
     * @param Selector $selector
     * @param string[] $tags
     * @return bool
     */
    private static function selectorContainsTag(Selector $selector, array $tags)
    {
        foreach ($tags as $tag) {
            if (preg_match('/(\\s|#|~|\\+|>|^)' . preg_quote($tag) . '($|\\.|#|~|\\+|\\[|>|:|\\s)/', $selector->getSelector()) != false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Selector $selector
     * @param string[] $classes
     * @return bool
     */
    private static function selectorContainsClass(Selector $selector, array $classes)
    {
        foreach ($classes as $class) {
            if (preg_match('/(\\s|#|~|\\+|>|\\w|\\d|^)\\.' . preg_quote($class) . '($|\\.|#|~|\\+|\\[|>|:|\\s)/', $selector->getSelector()) != false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Selector $selector
     * @param array $classes
     * @return bool
     */
    private static function selectorContainsClassAttribute(Selector $selector, array $classes)
    {
        if (preg_match_all('/\\[class([~|^$*]?)=[\'"](.+)[\'"]((?:\\si)?)\\]/', $selector, $attributes) > 0) {
            foreach ($attributes as $attribute) {
                $case = trim($attribute[3]) == 'i';
                switch ($attribute[1]) {
                    case '~': {
                        foreach (preg_split('/\\s/', $attribute[2]) as $classValue) {
                            foreach ($classes as $class) {
                                if (($case ? strcasecmp($class, $classValue) : strcmp($class, $classValue)) === 0) {
                                    return true;
                                }
                            }
                        }
                        break;
                    }
                    case '|': {
                        foreach ($classes as $class) {
                            if (preg_match('/^'.preg_quote($attribute[2]).'($|\\-.*$)/'.($case?'i':''), $classes)== 1) {
                                return true;
                            }
                        }
                        break;
                    }
                    case '^': {
                        foreach ($classes as $class) {
                            if (($case ? stripos($class, $attribute[2]) : strpos($class, $attribute[2])) === 0) {
                                return true;
                            }
                        }
                        break;
                    }
                    case '*': {
                        foreach ($classes as $class) {
                            if (($case ? stripos($class, $attribute[2]) : strpos($class, $attribute[2])) !== false) {
                                return true;
                            }
                        }
                        break;
                    }
                    case '$': {
                        foreach ($classes as $class) {
                            if (($case ? stripos(strrev($class), strrev($attribute[2])) : strpos(strrev($class), strrev($attribute[2]))) === 0) {
                                return true;
                            }
                        }
                        break;
                    }
                    default: {
                        foreach ($classes as $class) {
                            if (($case ? strcasecmp($class, $attribute[2]) : strcmp($class, $attribute[2])) === 0) {
                                return true;
                            }
                        }
                        break;
                    }
                }
            }
        }

        return false;
    }
}
