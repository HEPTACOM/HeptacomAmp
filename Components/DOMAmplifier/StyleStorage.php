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
        if (is_file(realpath($stylesheetUrl))) {
            $this->styles[] = file_get_contents($stylesheetUrl);
        } else {
            $this->styles[] = file_get_contents(realpath(implode(DIRECTORY_SEPARATOR, [
                Shopware()->DocPath(),
                substr($stylesheetUrl, strlen(Shopware()->Front()->Request()->getBaseUrl()))
            ])));
        }

        return $this;
    }

    /**
     * Gets the content of the extract styles.
     * @return string
     */
    public function getContent()
    {
        $customCss = join(' ', $this->styles);

        $themeVariables = Shopware()->Template()->getTemplateVars('theme');
        if (is_array($themeVariables)
            && array_key_exists('HeptacomAmpCustomCss', $themeVariables)
            && !empty($themeVariables['HeptacomAmpCustomCss'])) {
            $customCss = $themeVariables['HeptacomAmpCustomCss'];
        }

        return $customCss;
    }
}
