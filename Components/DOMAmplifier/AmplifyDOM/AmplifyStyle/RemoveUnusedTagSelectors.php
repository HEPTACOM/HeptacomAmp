<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use DOMDocument;
use DOMNode;
use DOMXPath;
use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyDOMStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Property\Selector;
use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Shopware\Components\Logger;
use Symfony\Component\CssSelector\CssSelectorConverter;

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
     * @var CssSelectorConverter
     */
    private $xpathConverter;

    /**
     * @var Logger
     */
    private $pluginLogger;

    public function __construct()
    {
        $this->xpathConverter = new CssSelectorConverter();
        $this->pluginLogger = Shopware()->Container()->get('PluginLogger');
    }

    /**
     * Process and ⚡lifies the given node and style.
     *
     * @param DOMNode  $domNode       the node to ⚡lify
     * @param Document $styleDocument the style to ⚡lify
     */
    public function amplify(DOMNode &$domNode, Document &$styleDocument)
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

                try {
                    $cleanedSelector = preg_replace('/:{1,2}[\w-]+(\(.*?\))?/m', '', $selector->getSelector());

                    $xpathSelector = $this->xpathConverter->toXPath($cleanedSelector);
                    $document = $domNode instanceof DOMDocument ? $domNode : $domNode->ownerDocument;
                    $xpath = new DOMXPath($document);

                    if ($xpath->query($xpathSelector)->length == 0) {
                        $selectorsToRemove[] = $selector;
                    }
                } catch (\Exception $exception) {
                    // TODO: log
                    $this->pluginLogger->error('Error while amplifying output', [$exception]);
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
     * @param mixed $selector
     *
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
