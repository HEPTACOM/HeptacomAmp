<?php

namespace HeptacomAmp\Components;

use HeptacomAmp\Components\PluginDependencies\Dependency;
use Shopware\Models\Shop\Shop;

/**
 * Class PluginDependencies
 * @package HeptacomAmp\Components
 */
class PluginDependencies
{
    private function __construct()
    {
        if (extension_loaded('dom')) {
            $this->dependencies[] = new Dependency('php DOM Extension', '*', phpversion('dom'), true);
        } else {
            $this->dependencies[] = new Dependency('php DOM Extension', '*', '', false);
        }

        foreach (Shopware()->Container()->get('models')->getRepository(Shop::class)->findAll() as $shop) {
            /** @var Shop $shop */
            if ($shop->getActive()) {
                $this->dependencies[] = new Dependency('HTTPS - Shop: ' . $shop->getName(), '*', '*', $shop->getSecure() || $shop->getAlwaysSecure());
            }
        }
    }

    /**
     * @var PluginDependencies
     */
    private static $instance;

    /**
     * Returns the singleton.
     * @return PluginDependencies The singleton.
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new PluginDependencies();
        }

        return static::$instance;
    }

    /**
     * @var Dependency[]
     */
    private $dependencies = [];

    /**
     * Returns all dependencies.
     * @return PluginDependencies\Dependency[]
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }
};
