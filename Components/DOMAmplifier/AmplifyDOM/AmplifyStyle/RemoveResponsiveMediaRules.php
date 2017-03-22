<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

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
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(Document& $styleDocument)
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
