<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\RuleSet\DeclarationBlock;

/**
 * Class NoRuleIsImportant
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class NoRuleIsImportant implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(Document& $styleDocument)
    {
        /** @var DeclarationBlock[] $declarationBlocks */
        $declarationBlocks = $styleDocument->getAllDeclarationBlocks();
        foreach ($declarationBlocks as $declarationBlock) {
            /** @var DeclarationBlock $declarationBlock */
            foreach ($declarationBlock->getRules() as $rule) {
                /** @var Rule $rule */
                $rule->setIsImportant(false);
            }
        }
    }
}
