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
}
