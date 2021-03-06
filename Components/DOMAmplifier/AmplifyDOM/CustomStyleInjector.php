<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\StyleStorage;
use HeptacomAmp\Components\FileCache;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\OutputFormat;
use Sabberworm\CSS\Parser;

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

    public function __construct(StyleStorage $styleStorage, FileCache $fileCache)
    {
        $this->styleStorage = $styleStorage;
        $this->fileCache = $fileCache;
    }

    /**
     * Registers a ⚡lifier module.
     *
     * @param IAmplifyStyle|IAmplifyDOMStyle $amplify the module to use
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
     *
     * @param DOMNode $node the node to ⚡lify
     *
     * @return DOMNode the ⚡lified node
     */
    public function amplify(DOMNode $node)
    {
        $styleAmplifier = $this->styleAmplifier;

        /** @var Document $styleContent */
        $styleContent = $this->fileCache->getCachedSerializedContents($this->styleStorage->getContent(), 'amp_css', function ($cssContent) use ($styleAmplifier) {
            $styleDocument = static::parseCss($cssContent);

            foreach ($styleAmplifier as $amplifier) {
                $amplifier->amplify($styleDocument);
            }

            return $styleDocument;
        }, 'serialize', 'unserialize');

        foreach ($this->styleDOMAmplifier as $amplifier) {
            $amplifier->amplify($node, $styleContent);
        }

        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        foreach ($document->getElementsByTagName('head') as $head) {
            /** @var DOMElement $head */
            $style = $document->createElement('style');
            $style->setAttributeNode($document->createAttribute('amp-custom'));
            $style->textContent = static::renderCss($styleContent);
            $head->appendChild($style);

            break;
        }

        return $node;
    }

    /**
     * @return string
     */
    public static function renderCss(Document $styleDocument)
    {
        return $styleDocument->render(OutputFormat::createCompact());
    }

    /**
     * @return Document
     */
    public static function parseCss($stylesheet)
    {
        return (new Parser($stylesheet))->parse();
    }
}
