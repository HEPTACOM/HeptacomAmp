<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\RuleSet\AtRuleSet;

/**
 * Class RemoveMicrosoftAtRules
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RemoveMicrosoftAtRules implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(Document & $styleDocument)
    {
        $toRemove = [];

        foreach ($styleDocument->getAllRuleSets() as $ruleSet) {
            if ($ruleSet instanceof AtRuleSet) {
                /** @var AtRuleSet $ruleSet */
                if (stripos($ruleSet->atRuleName(), '-ms-') === 0) {
                    $toRemove[] = $ruleSet;
                }
            }
        }

        array_walk($toRemove, [$styleDocument, 'remove']);
    }
}
