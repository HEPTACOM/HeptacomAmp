<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\StyleStorage;

class StyleExtractor implements IAmplifyDOM
{
    /**
     * @var StyleStorage
     */
    private $styleStorage;

    public function __construct(StyleStorage $styleStorage)
    {
        $this->styleStorage = $styleStorage;
    }

    /**
     * Process and ⚡lifies the given node.
     *
     * @param DOMNode $node the node to ⚡lify
     *
     * @return DOMNode the ⚡lified node
     */
    public function amplify(DOMNode $node)
    {
        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        foreach ($document->getElementsByTagName('style') as $style) {
            /** @var DOMNode $style */
            if (is_null($style->attributes->getNamedItem('amp-boilerplate'))) {
                $this->styleStorage->addStyle($style->textContent, 'styleTag');
                $style->parentNode->removeChild($style);
            }
        }

        return $node;
    }
}
