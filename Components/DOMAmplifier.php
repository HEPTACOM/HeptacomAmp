<?php

namespace HeptacomAmp\Components;

use DOMDocument;
use HeptacomAmp\Components\DOMAmplifier\Exceptions\HTMLLoadException;
use HeptacomAmp\Components\DOMAmplifier\Exceptions\HTMLSaveException;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;

/**
 * Class DOMAmplifier
 * @package HeptacomAmp\Components
 */
class DOMAmplifier
{
    /**
     * @var IAmplifyDOM[]
     */
    private $amplifier = [];

    /**
     * Registers a ⚡lifier module.
     * @param IAmplifyDOM $amplify The module to use.
     */
    public function useAmplifier(IAmplifyDOM $amplify)
    {
        if (!empty($amplify)) {
            $this->amplifier[] = $amplify;
        }
    }

    /**
     * ⚡lifies the given HTML.
     * @param string $html The HTML code to ⚡lify.
     * @return string The ⚡lified HTML code.
     * @throws HTMLLoadException
     * @throws HTMLSaveException
     */
    public function amplifyHTML($html)
    {
        $document = new DOMDocument();

        if (!$document->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'))) {
            throw new HTMLLoadException();
        }

        $document = $this->amplifyDOM($document);

        if (!($parsed = $document->saveHTML())) {
            throw new HTMLSaveException();
        }

        return $parsed;
    }

    /**
     * ⚡lifies the given DOM.
     * @param DOMDocument $document The DOM to ⚡lify.
     * @return DOMDocument The ⚡lified DOM.
     */
    public function amplifyDOM(DOMDocument $document)
    {
        foreach ($this->amplifier as $amplifier) {
            $document = $amplifier->amplify($document);
        }

        return $document;
    }
}
