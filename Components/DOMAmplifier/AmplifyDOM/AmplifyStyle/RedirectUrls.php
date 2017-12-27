<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Sabberworm\CSS\Value\CSSString;
use Sabberworm\CSS\Value\URL;

/**
 * Class RedirectUrls
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RedirectUrls implements IAmplifyStyle
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

        foreach ($styleDocument->getAllValues() as $value) {
            if ($value instanceof URL) {
                /** @var URL $value */
                $origPath = trim($value->getURL(), '"');

                if (stripos($origPath, '://') !== false) {
                    // file is referenced absolute, not relative
                    continue;
                }

                $exploded = explode('?', $origPath);
                $origPath = array_shift($exploded);
                $params = empty($exploded) ? '' : '?' . array_shift($exploded);

                $path = realpath(implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'web', 'cache', $origPath]));
                $path = implode(DIRECTORY_SEPARATOR, [
                    Shopware()->Front()->Request()->getBaseUrl(),
                    substr($path, strlen(Shopware()->DocPath()))
                ]);
                if (strpos($path,
                        implode(DIRECTORY_SEPARATOR, ['frontend', '_public', 'src', 'fonts', 'shopware'])) !== false
                ) {
                    $value->setURL(new CSSString($path . $params));
                }
            }
        }
    }
}
