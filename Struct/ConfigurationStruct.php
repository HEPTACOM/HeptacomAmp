<?php declare(strict_types=1);

namespace HeptacomAmp\Struct;

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
     * @var bool
     */
    private $debug;

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
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
     *
     * @return ConfigurationStruct
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     *
     * @return ConfigurationStruct
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;

        return $this;
    }
}
