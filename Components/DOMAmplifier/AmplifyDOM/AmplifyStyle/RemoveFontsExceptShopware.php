<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Property\Import;
use Sabberworm\CSS\RuleSet\AtRuleSet;

/**
 * Class RemoveFontsExceptShopware
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RemoveFontsExceptShopware implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(Document& $styleDocument)
    {
        foreach ($styleDocument->getAllRuleSets() as $ruleSet) {
            if ($ruleSet instanceof AtRuleSet) {
                /** @var AtRuleSet $ruleSet */
                if ($ruleSet->atRuleName() == 'font-face') {
                    $rule = array_shift($ruleSet->getRules('font-family'));
                    if (!is_null($rule) && strcasecmp(trim($rule->getValue(), '"\''), 'shopware') !== 0) {
                        $styleDocument->remove($ruleSet);
                    }
                }
            }
        }
        foreach ($styleDocument->getContents() as $content) {
            if ($content instanceof Import) {
                $styleDocument->remove($content);
            }
        }
    }
}
