<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\StyleStorage;
use HeptacomAmp\Components\FileCache;
use Sabberworm\CSS\OutputFormat;
use Sabberworm\CSS\Parser;

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
     * @var FileCache
     */
    private $fileCache;

    /**
     * @var IAmplifyStyle[]
     */
    private $styleAmplifier = [];

    /**
     * @var IAmplifyDOMStyle[]
     */
    private $styleDOMAmplifier = [];

    /**
     * CSSMerge constructor.
     * @param StyleStorage $styleStorage
     */
    public function __construct(StyleStorage $styleStorage, FileCache $fileCache)
    {
        $this->styleStorage = $styleStorage;
        $this->fileCache = $fileCache;
    }

    /**
     * Registers a ⚡lifier module.
     * @param IAmplifyStyle|IAmplifyDOMStyle $amplify The module to use.
     */
    public function useAmplifier($amplify)
    {
        if (!empty($amplify)) {
            if ($amplify instanceof IAmplifyStyle) {
                $this->styleAmplifier[] = $amplify;
            }

            if ($amplify instanceof IAmplifyDOMStyle) {
                $this->styleDOMAmplifier[] = $amplify;
            }
        }
    }

    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    public function amplify(DOMNode $node)
    {
        $styleAmplifier = $this->styleAmplifier;

        $styleContent = $this->fileCache->getCachedContents($this->styleStorage->getContent(), 'amp_css', function ($cssContent) use ($styleAmplifier) {
            $styleDocument = (new Parser($cssContent))->parse();

            foreach ($styleAmplifier as $amplifier) {
                $amplifier->amplify($styleDocument);
            }

            return $styleDocument->render(OutputFormat::createCompact());
        });

        $styleDocument = (new Parser($styleContent))->parse();

        foreach ($this->styleDOMAmplifier as $amplifier) {
            $amplifier->amplify($node, $styleDocument);
        }

        $styleContent = $styleDocument->render(OutputFormat::createCompact());

        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        foreach ($document->getElementsByTagName('head') as $head) {
            /** @var DOMElement $head */
            $style = $document->createElement('style');
            $style->setAttributeNode($document->createAttribute('amp-custom'));
            $style->textContent = $styleContent;
            $head->appendChild($style);

            break;
        }

        return $node;
    }
}
