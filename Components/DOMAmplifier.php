<?php declare(strict_types=1);

namespace HeptacomAmp\Components;

use DOMDocument;
use HeptacomAmp\Components\DOMAmplifier\Exceptions\HTMLLoadException;
use HeptacomAmp\Components\DOMAmplifier\Exceptions\HTMLSaveException;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;

class DOMAmplifier
{
    /**
     * @var IAmplifyDOM[]
     */
    private $amplifier = [];

    /**
     * @var FileCache
     */
    private $fileCache;

    public function __construct(FileCache $fileCache)
    {
        $this->fileCache = $fileCache;
    }

    /**
     * Registers a ⚡lifier module.
     *
     * @param IAmplifyDOM $amplify the module to use
     */
    public function useAmplifier(IAmplifyDOM $amplify)
    {
        if (!empty($amplify)) {
            $this->amplifier[] = $amplify;
        }
    }

    /**
     * ⚡lifies the given HTML.
     *
     * @param string $html the HTML code to ⚡lify
     *
     * @throws HTMLLoadException
     * @throws HTMLSaveException
     *
     * @return string the ⚡lified HTML code
     */
    public function amplifyHTML($html)
    {
        $amplifier = $this->amplifier;

        return $this->fileCache->getCachedContents($html, 'amp_html', function ($htmlData) use ($amplifier) {
            $document = new DOMDocument();

            if (!$document->loadHTML(mb_convert_encoding($htmlData, 'HTML-ENTITIES', 'UTF-8'))) {
                throw new HTMLLoadException();
            }

            $document = static::amplifyDOMWithFilter($document, $amplifier);

            if (!($parsed = $document->saveHTML())) {
                throw new HTMLSaveException();
            }

            return $parsed;
        });
    }

    /**
     * ⚡lifies the given DOM.
     *
     * @param DOMDocument $document the DOM to ⚡lify
     *
     * @return DOMDocument the ⚡lified DOM
     */
    public function amplifyDOM(DOMDocument $document)
    {
        return static::amplifyDOMWithFilter($document, $this->amplifier);
    }

    /**
     * ⚡lifies the given DOM.
     *
     * @param DOMDocument   $document  the DOM to ⚡lify
     * @param IAmplifyDOM[] $amplifier the filter
     *
     * @return DOMDocument the ⚡lified DOM
     */
    public static function amplifyDOMWithFilter(DOMDocument $document, array $amplifier)
    {
        foreach ($amplifier as $amplify) {
            $document = $amplify->amplify($document);
        }

        return $document;
    }
}
