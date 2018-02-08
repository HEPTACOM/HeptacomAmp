<?php

namespace HeptacomAmp\Struct;

/**
 * Class ConfigurationStruct
 * @package HeptacomAmp\Struct
 */
class ConfigurationStruct
{
    /**
     * @var bool
     */
    private $active;

    /**
     * @var string
     */
    private $theme;

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return ConfigurationStruct
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     * @return ConfigurationStruct
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }
}
