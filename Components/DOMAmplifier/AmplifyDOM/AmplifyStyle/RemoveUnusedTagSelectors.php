<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyDOMStyle;
use phpQuery;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Property\Selector;
use Sabberworm\CSS\RuleSet\DeclarationBlock;

/**
 * Class RemoveUnusedTagSelectors
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RemoveUnusedTagSelectors implements IAmplifyDOMStyle
{
    /**
     * @var array
     */
    private static $whitelist = [
        'amp-img',
        'amp-accordion',
        'amp-sidebar',
        // to be continued
    ];

    /**
     * Process and ⚡lifies the given node and style.
     * @param DOMNode $domNode The node to ⚡lify.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(DOMNode& $domNode, Document& $styleDocument)
    {
        foreach ($styleDocument->getAllDeclarationBlocks() as $declarationBlock) {
            /** @var DeclarationBlock $declarationBlock */
            /** @var Selector[] $selectorsToRemove */
            $selectorsToRemove = [];
            foreach ($declarationBlock->getSelectors() as $selector) {
                /** @var Selector $selector */

                if (static::isWhitelisted($selector)) {
                    continue;
                }

                if (phpQuery::pq($selector->getSelector(), $domNode)->count() == 0) {
                    $selectorsToRemove[] = $selector;
                }
            }


            if (count($selectorsToRemove) == count($declarationBlock->getSelectors())) {
                $styleDocument->remove($declarationBlock);
            } else {
                array_walk($selectorsToRemove, [$declarationBlock, 'removeSelector']);
            }
        }
    }

    /**
     * @param $selector
     * @return bool
     */
    private static function isWhitelisted($selector)
    {
        foreach (static::$whitelist as $whitelistedSelector) {
            if (strpos($selector, $whitelistedSelector) !== false) {
                return true;
            }
        }
        return false;
    }
}
