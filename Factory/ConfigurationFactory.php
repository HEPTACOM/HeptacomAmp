<?php declare(strict_types=1);

namespace HeptacomAmp\Factory;

use HeptacomAmp\Struct\ConfigurationStruct;

class ConfigurationFactory
{
    const ACTIVE = 'active';

    const THEME = 'theme';

    const DEBUG = 'debug';

    /**
     * @return ConfigurationStruct
     */
    public function hydrate(array $data)
    {
        return (new ConfigurationStruct())
            ->setActive(boolval($data[self::ACTIVE]))
            ->setDebug(boolval($data[self::DEBUG]))
            ->setTheme($data[self::THEME] ?: '');
    }
}
