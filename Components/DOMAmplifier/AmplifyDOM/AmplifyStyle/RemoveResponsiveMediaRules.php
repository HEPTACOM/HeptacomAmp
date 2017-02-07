<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\AtRuleBlockList;
use Sabberworm\CSS\CSSList\Document;

/**
 * Class RemoveResponsiveMediaRules
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RemoveResponsiveMediaRules implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param DOMNode $domNode The node to ⚡lify.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(DOMNode& $domNode, Document& $styleDocument)
    {
        foreach ($styleDocument->getContents() as $list) {
            if ($list instanceof AtRuleBlockList) {
                if ($list->atRuleName() == 'media') {
                    if (stripos($list->atRuleArgs(), 'min-width') !== false ||
                        stripos($list->atRuleArgs(), 'print') !== false) {
                        $styleDocument->remove($list);
                    }
                }
            }
        }
    }
}
