<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\RuleSet\DeclarationBlock;

/**
 * Class HtmlEntitiesToUnicodeNotation
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class HtmlEntitiesToUnicodeNotation implements IAmplifyStyle
{
    /**
     * @param string $c
     * @return int
     */
    private static function ord_utf8($c)
    {
        $b0 = ord($c[0]);
        if ($b0 < 0x10) {
            return $b0;
        }

        $b1 = ord($c[1]);
        if ($b0 < 0xE0) {
            return (($b0 & 0x1F) << 6) + ($b1 & 0x3F);
        }

        return (($b0 & 0x0F) << 12) + (($b1 & 0x3F) << 6) + (ord($c[2]) & 0x3F);
    }

    /**
     * Process and ⚡lifies the given node and style.
     * @param DOMNode $domNode The node to ⚡lify.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(DOMNode& $domNode, Document& $styleDocument)
    {
        foreach ($styleDocument->getAllDeclarationBlocks() as $declarationBlock) {
            /** @var DeclarationBlock $declarationBlock */
            foreach ($declarationBlock->getRules() as $rule) {
                if ($rule->getRule() == 'content') {
                    $value = trim($rule->getValue(), '"');

                    if (strlen($value) != mb_strlen($value)) {
                        $rule->setValue('"\\' . base_convert(static::ord_utf8($value), 10, 16) . '"');
                    }
                }
            }
        }

        return [$domNode, $styleDocument];
    }
}
