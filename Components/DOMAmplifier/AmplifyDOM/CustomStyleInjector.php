<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\StyleStorage;
use Sabberworm\CSS\OutputFormat;

/**
 * Class CustomStyleInjector
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
class CustomStyleInjector implements IAmplifyDOM
{
    /**
     * @var StyleStorage
     */
    private $styleStorage;

    /**
     * CSSMerge constructor.
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
    public function amplify(DOMNode $node)
    {
        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        foreach ($document->getElementsByTagName('head') as $head) {
            /** @var DOMElement $head */
            $style = $document->createElement('style');
            $style->setAttributeNode($document->createAttribute('amp-custom'));
            $style->textContent = $this->styleStorage->parseToStylesheet()->render(OutputFormat::createCompact());
            $head->appendChild($style);

            break;
        }

        return $node;
    }
}
