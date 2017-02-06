<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Property\Selector;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\RuleSet\DeclarationBlock;

/**
 * Class RemoveVendorPrefixedItems
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RemoveVendorPrefixedItems implements IAmplifyStyle
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

            foreach ($declarationBlock->getSelectors() as $selector) {
                /** @var Selector $selector */

                if (strpos($selector->getSelector(), '-webkit-') !== false
                    || strpos($selector->getSelector(), '-moz-') !== false
                    || strpos($selector->getSelector(), '-ms-') !== false
                    || strpos($selector->getSelector(), '-o-') !== false) {
                    $styleDocument->remove($declarationBlock);
                    continue;
                }

                foreach ($declarationBlock->getRules() as $rule) {
                    /** @var Rule $rule */
                    // TODO: should use regex
                    if (strpos($rule->getValue(), '-webkit-') !== false ||
                        strpos($rule->getValue(), '-moz-') !== false  ||
                        strpos($rule->getValue(), '-ms-') !== false  ||
                        strpos($rule->getValue(), '-o-') !== false) {
                        $declarationBlock->removeRule($rule);
                        continue;
                    }
                }

                $declarationBlock->removeRule('-webkit-');
                $declarationBlock->removeRule('-moz-');
                $declarationBlock->removeRule('-ms-');
                $declarationBlock->removeRule('-o-');
            }
        }
    }
}
