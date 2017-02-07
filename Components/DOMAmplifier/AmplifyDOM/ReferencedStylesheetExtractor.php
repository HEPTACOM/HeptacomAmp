<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\StyleStorage;

/**
 * Class ReferencedStylesheetExtractor
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
class ReferencedStylesheetExtractor implements IAmplifyDOM
{
    /**
     * @var StyleStorage
     */
    private $styleStorage;

    /**
     * StyleExtractor constructor.
     * @param StyleStorage $styleStorage
     */
    public function __construct(StyleStorage $styleStorage)
    {
        $this->styleStorage = $styleStorage;
    }

    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    function amplify(DOMNode $node)
    {
        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        foreach ($document->getElementsByTagName('link') as $style) {
            /** @var DOMElement $style */
            if ($style->getAttribute('rel') === 'stylesheet') {
                $this->styleStorage->addStylesheet($style->getAttribute('href'));
                $style->parentNode->removeChild($style);
            }
        }

        return $node;
    }
}
