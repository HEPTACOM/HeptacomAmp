<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Sabberworm\CSS\Value\Size;
use Sabberworm\CSS\Value\ValueList;

class ShortenRulesToKnownShorthands implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     *
     * @param Document $styleDocument the style to ⚡lify
     */
    public function amplify(Document &$styleDocument)
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
                    'border-width',
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
     * @return bool
     */
    private static function equalSizes(Size $a, Size $b)
    {
        return $a->getSize() == $b->getSize() && $a->getUnit() == $b->getUnit();
    }

    /**
     * @return bool
     */
    private static function filterSizeValues($value)
    {
        return $value instanceof Size;
    }
}
