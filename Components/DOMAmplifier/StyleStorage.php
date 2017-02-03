<?php

namespace HeptacomAmp\Components\DOMAmplifier;

use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Parser;

/**
 * Class StyleStorage
 * @package HeptacomAmp\Components\DOMAmplifier
 */
class StyleStorage
{
    /**
     * @var string[]
     */
    private $styles = [];

    /**
     * @var Document
     */
    private $cachedParsedDocument;

    /**
     * Add a style to the storage.
     * @param string $style
     * @return $this
     */
    public function addStyle($style)
    {
        $this->styles[] = $style;
        $this->cachedParsedDocument = null;
        return $this;
    }

    /**
     * Adds a stylesheet reference to the storage.
     * @param $stylesheetUrl
     * @return $this
     */
    public function addStylesheet($stylesheetUrl)
    {
        $this->styles[] = file_get_contents($stylesheetUrl);
        $this->cachedParsedDocument = null;
        return $this;
    }

    /**
     * Generates if necessary a stylesheet document.
     * @return Document
     */
    public function parseToStylesheet()
    {
        if (is_null($this->cachedParsedDocument)) {
            $this->cachedParsedDocument = (new Parser(join(' ', $this->styles)))->parse();
        }

        return $this->cachedParsedDocument;
    }
}
