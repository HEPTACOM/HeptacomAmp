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
 * Class RenameClassNames
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RenameClassNames implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param DOMNode $domNode The node to ⚡lify.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(DOMNode& $domNode, Document& $styleDocument)
    {
        $classNameFilters = [];
        $selectors = [];

        foreach ($styleDocument->getAllDeclarationBlocks() as $declarationBlock) {
            /** @var DeclarationBlock $declarationBlock */
            foreach ($declarationBlock->getSelectors() as $selector) {
                /** @var Selector $selector */
                $selectors[] = $selector->getSelector();
                if (preg_match_all('/\\[class([~|^$*]?)=[\'"](.+)[\'"]((?:\\si)?)\\]/', $selector, $attributeMatches, PREG_SET_ORDER) > 0) {
                    foreach ($attributeMatches as $attributeMatch) {
                        $quote = preg_quote($attributeMatch[2]);
                        $suffix = trim($attributeMatch[3]) == 'i'?'i':'';

                        switch ($attributeMatch[1]) {
                            case '~': {
                                $classNameFilters[] = "/(^|\\s)$quote(\$|\\s)/$suffix";
                                break;
                            }
                            case '|': {
                                $classNameFilters[] = "/(^|\\s)$quote(-.*\$|\\s)/$suffix";
                                break;
                            }
                            case '^': {
                                $classNameFilters[] = "/^$quote/$suffix";
                                break;
                            }
                            case '*': {
                                $classNameFilters[] = "/$quote/$suffix";
                                break;
                            }
                            case '$': {
                                $classNameFilters[] = "/$quote\$/$suffix";
                                break;
                            }
                            default: {
                                $classNameFilters[] = "/^$quote\$/$suffix";
                                break;
                            }
                        }
                    }
                }
            }
        }

        /** @var string[] $classes */
        $classes = [];
        $nodes = new DOMNodeRecursiveIterator($domNode->childNodes);
        foreach ($nodes->getRecursiveIterator() as $subnode) {
            if ($subnode instanceof DOMElement &&
                !empty($class = $subnode->getAttribute('class'))) {
                foreach (explode(' ', $class) as $classItem) {
                    if (!in_array($classItem, $classes)) {
                        $classes[] = $classItem;
                    }
                }
            }
        }

        $classes = array_filter($classes, function ($class) use ($classNameFilters) {
            return !static::classNameMatchesRegex($class, $classNameFilters) && strlen($class) > 2;
        });

        usort($classes, function ($a, $b) {
            $aL = strlen($a);
            $bL = strlen($b);

            if ($aL == $bL) {
                return -strcmp($a, $b);
            } elseif ($aL > $bL) {
                return -1;
            } else {
                return 1;
            }
        });


        /** @var string $classSet */
        $classSet = "qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM";
        /** @var int $classNumber */
        $classNumber = 0;

        /** @var string[] $translations */
        $translations = [];

        foreach ($classes as $class) {
            $classKeyNumber = $classNumber++;

            $classKey = substr($classSet, $classKeyNumber % strlen($classSet), 1);
            while ($classKeyNumber >= strlen($classSet)) {
                $classKeyNumber /= strlen($classSet);
                $classKey .= substr($classSet, $classKeyNumber % strlen($classSet), 1);
            }

            $translations[$class] = $classKey;
        }

        foreach ($nodes->getRecursiveIterator() as $subnode) {
            if ($subnode instanceof DOMElement &&
                !empty($class = $subnode->getAttribute('class'))) {
                $newClasses = [];
                foreach (explode(' ', $class) as $classItem) {
                    if (array_key_exists($classItem, $translations)) {
                        $newClasses[] = $translations[$classItem];
                    } else {
                        $newClasses[] = $classItem;
                    }
                }
                $subnode->setAttribute('class', join(' ', $newClasses));
            }
        }

        foreach ($styleDocument->getAllDeclarationBlocks() as $declarationBlock) {
            /** @var DeclarationBlock $declarationBlock */
            $selectors = [];

            foreach ($declarationBlock->getSelectors() as $selector) {
                $sel = $selector->getSelector();
                foreach ($classes as $class) {
                    if (array_key_exists($class, $translations)) {
                        $sel = str_replace('.'.$class, '.'.$translations[$class], $sel);
                    }
                }
                $selectors[] = $sel;
            }

            $declarationBlock->setSelectors($selectors);
        }
    }

    /**
     * @param string $class
     * @param string[] $regexes
     * @return bool
     */
    private static function classNameMatchesRegex($class, $regexes)
    {
        foreach ($regexes as $regex) {
            if (preg_match($regex, $class) > 0) {
                return true;
            }
        }

        return false;
    }
}
