<?php

namespace HeptacomAmp\Components\DOMAmplifier;

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
     * Add a style to the storage.
     * @param string $style
     * @return $this
     */
    public function addStyle($style)
    {
        $this->styles[] = $style;
        return $this;
    }

    /**
     * Adds a stylesheet reference to the storage.
     * @param $stylesheetUrl
     * @return $this
     */
    public function addStylesheet($stylesheetUrl)
    {
        $stylesheetUrl = static::getValidStylesheetUrl($stylesheetUrl);
        $this->styles[] = file_get_contents($stylesheetUrl);

        return $this;
    }

    /**
     * @param string $stylesheetUrl
     * @return string
     */
    private static function getValidStylesheetUrl($stylesheetUrl)
    {
        if (is_file($path = realpath($stylesheetUrl))) {
            return $path;
        } elseif (is_file($path = realpath(implode(DIRECTORY_SEPARATOR, [
            Shopware()->DocPath(),
            substr($stylesheetUrl, strlen(Shopware()->Front()->Request()->getBaseUrl()))
        ])))) {
            return $path;
        } elseif (is_file($path = realpath(implode(DIRECTORY_SEPARATOR, [
            Shopware()->DocPath(),
            substr($stylesheetUrl, strlen(Shopware()->Front()->Request()->getPathInfo()))
        ])))) {
            return $path;
        }

        return $stylesheetUrl;
    }

    /**
     * Gets the content of the extract styles.
     * @return string
     */
    public function getContent()
    {
        return join(' ', $this->styles);
    }
}
