<?php

namespace HeptacomAmp\Components;

class CssAmplifier
{
    /**
     * @var string
     */
    protected $css;

    /**
     * @param $css
     * @return string
     */
    public function processCss($css)
    {
        $this->css = $css;

        return $this->css;
    }
}
