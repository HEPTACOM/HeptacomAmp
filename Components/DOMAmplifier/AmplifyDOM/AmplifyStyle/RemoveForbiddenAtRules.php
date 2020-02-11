<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\RuleSet\AtRuleSet;

class RemoveForbiddenAtRules implements IAmplifyStyle
{
    /**
     * @var string[]
     */
    protected static $allowedAtRules = [
        'font-face',
        'keyframes',
        'media',
        'supports',
    ];

    /**
     * Process and ⚡lifies the given node and style.
     *
     * @param Document $styleDocument the style to ⚡lify
     */
    public function amplify(Document &$styleDocument)
    {
        $toRemove = [];

        foreach ($styleDocument->getAllRuleSets() as $ruleSet) {
            if ($ruleSet instanceof AtRuleSet) {
                if (!in_array(strtolower($ruleSet->atRuleName()), self::$allowedAtRules)) {
                    $toRemove[] = $ruleSet;
                }
            }
        }

        array_walk($toRemove, [$styleDocument, 'remove']);
    }
}
