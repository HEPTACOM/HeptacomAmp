<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\RuleSet\DeclarationBlock;

/**
 * Class RemoveDuplicateValues
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RemoveDuplicateValues implements IAmplifyStyle
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

            $duplicateRules = [];

            foreach ($declarationBlock->getRules() as $rule) {
                $duplicateRules[$rule->getRule()][] = $rule;
            }

            array_walk($duplicateRules, function ($items) use ($declarationBlock) {
                /*
                 * TODO: This logic needs to be replaced.
                 * It should find the last occurrence of a
                 * rule in a block and use only that one.
                 * No rearrangement should be done, because
                 * that would be prone to errors. Instead
                 * maybe we could try to convert the value
                 * of that last rule (if possible) to a
                 * shorter form (e.g. "rem" to "px" or
                 * "rgb()" to "#hex").
                 */
                usort($items, 'strlen');
                array_shift($items);
                array_walk($items, [$declarationBlock, 'removeRule']);
            });
        }
    }
}
