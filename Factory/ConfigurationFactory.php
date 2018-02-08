<?php

namespace HeptacomAmp\Factory;

use HeptacomAmp\Struct\ConfigurationStruct;

/**
 * Class ConfigurationFactory
 * @package HeptacomAmp\Factory
 */
class ConfigurationFactory
{
    const ACTIVE = 'active';

    const THEME = 'theme';

    /**
     * @param array $data
     * @return ConfigurationStruct
     */
    public function hydrate(array $data)
    {
        return (new ConfigurationStruct())
            ->setActive(boolval($data[self::ACTIVE]))
            ->setTheme($data[self::THEME] ?: '');
    }
}
