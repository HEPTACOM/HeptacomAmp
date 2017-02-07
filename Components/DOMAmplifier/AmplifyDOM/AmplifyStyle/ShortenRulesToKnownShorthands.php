<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Sabberworm\CSS\Value\Size;
use Sabberworm\CSS\Value\Value;
use Sabberworm\CSS\Value\ValueList;

/**
 * Class ShortenRulesToKnownShorthands
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class ShortenRulesToKnownShorthands implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param DOMNode $domNode The node to ⚡lify.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(DOMNode& $domNode, Document& $styleDocument)
    {
        /** @var DeclarationBlock[] $declarationBlocks */
        $declarationBlocks = $styleDocument->getAllDeclarationBlocks();
        foreach ($declarationBlocks as $declarationBlock) {
            /** @var DeclarationBlock $declarationBlock */
            foreach ($declarationBlock->getRules() as $rule) {
                /** @var Rule $rule */
                if (in_array($rule->getRule(), [
                    'margin',
                    'padding',
                    'border-width'
                ])) {
                    $values = $rule->getValue();
                    if ($values instanceof ValueList) {
                        /** @var Size[] $components */
                        $components = array_filter($values->getListComponents(), [static::class, 'filterSizeValues']);
                        if (count($components) == 4) {
                            if (static::equalSizes($components[3], $components[1])) {
                                array_pop($components);
                                if (static::equalSizes($components[2], $components[0])) {
                                    array_pop($components);
                                    if (static::equalSizes($components[1], $components[0])) {
                                        array_pop($components);
                                    }
                                }
                            }

                            $values->setListComponents($components);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param Size $a
     * @param Size $b
     * @return bool
     */
    private static function equalSizes(Size $a, Size $b)
    {
        return $a->getSize() == $b->getSize() && $a->getUnit() == $b->getUnit();
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private static function filterSizeValues($value)
    {
        return $value instanceof Size;
    }
}
