<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier;

class StyleStorage
{
    /**
     * @var string[][]
     */
    private $styles = [];

    /**
     * Add a style to the storage.
     *
     * @param string $style
     *
     * @return $this
     */
    public function addStyle($style, $origin = null)
    {
        $this->styles[] = [
            'content' => $style,
            'origin' => $origin,
        ];

        return $this;
    }

    /**
     * Adds a stylesheet reference to the storage.
     *
     * @param mixed $stylesheetUrl
     *
     * @return $this
     */
    public function addStylesheet($stylesheetUrl)
    {
        if (is_file(realpath($stylesheetUrl))) {
            $this->addStyle(file_get_contents($stylesheetUrl), 'externalStylesheet');
        } else {
            $this->addStyle(file_get_contents(realpath(implode(DIRECTORY_SEPARATOR, [
                Shopware()->DocPath(),
                substr($stylesheetUrl, strlen(Shopware()->Front()->Request()->getBaseUrl())),
            ]))), 'externalStylesheet');
        }

        return $this;
    }

    /**
     * Gets the content of the extract styles.
     *
     * @return string
     */
    public function getContent()
    {
        $themeVariables = Shopware()->Template()->getTemplateVars('theme');
        if (is_array($themeVariables)
            && array_key_exists('HeptacomAmpCustomCss', $themeVariables)
            && !empty($themeVariables['HeptacomAmpCustomCss'])) {
            $css = join(' ', [
                $themeVariables['HeptacomAmpCustomCss'],
                $this->getContentByOrigin(['fontTag', 'inline']),
            ]);
        } else {
            $css = $this->getContentByOrigin();
        }

        return $css;
    }

    /**
     * @return string
     */
    private function getContentByOrigin(array $origins = [])
    {
        $css = [];

        foreach ($this->styles as $style) {
            if (in_array($style['origin'], $origins) || empty($origins)) {
                $css[] = $style['content'];
            }
        }

        return join(' ', $css);
    }
}
