<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Sabberworm\CSS\Value\CSSString;
use Sabberworm\CSS\Value\URL;

class RedirectUrls implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     *
     * @param Document $styleDocument the style to ⚡lify
     */
    public function amplify(Document &$styleDocument)
    {
        /** @var DeclarationBlock[] $declarationBlocks */
        $declarationBlocks = $styleDocument->getAllDeclarationBlocks();
        foreach ($declarationBlocks as $declarationBlock) {
            /** @var DeclarationBlock $declarationBlock */
            foreach ($declarationBlock->getRules() as $rule) {
                /* @var Rule $rule */
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

                if ($path === false) {
                    // file does not exist
                    continue;
                }

                $path = implode(DIRECTORY_SEPARATOR, [
                    Shopware()->Front()->Request()->getBaseUrl(),
                    substr($path, strlen(Shopware()->DocPath())),
                ]);

                $value->setURL(new CSSString($path . $params));
            }
        }
    }
}
