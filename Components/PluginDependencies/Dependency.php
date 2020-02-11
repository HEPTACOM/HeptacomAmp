<?php declare(strict_types=1);

namespace HeptacomAmp\Components\PluginDependencies;

class Dependency
{
    /**
     * Name of the dependency.
     *
     * @var string
     */
    private $name;

    /**
     * Version string of the expected version.
     *
     * @var string
     */
    private $requiredVersion;

    /**
     * Version string of the currently installed version.
     *
     * @var string
     */
    private $installedVersion;

    /**
     * Identifier whether the dependency is fulfilled.
     *
     * @var bool
     */
    private $ok;

    /**
     * @param string $name             name of the dependency
     * @param string $requiredVersion  version string of the expected version
     * @param string $installedVersion version string of the currently installed version
     * @param bool   $ok               identifier whether the dependency is fulfilled
     */
    public function __construct($name, $requiredVersion, $installedVersion, $ok)
    {
        $this->name = $name;
        $this->requiredVersion = $requiredVersion;
        $this->installedVersion = $installedVersion;
        $this->ok = $ok;
    }

    /**
     * Returns Name of the dependency.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns version string of the expected version.
     *
     * @return string
     */
    public function getRequiredVersion()
    {
        return $this->requiredVersion;
    }

    /**
     * Returns version string of the currently installed version.
     *
     * @return string
     */
    public function getInstalledVersion()
    {
        return $this->installedVersion;
    }

    /**
     * Returns identifier whether the dependency is fulfilled.
     *
     * @return bool
     */
    public function isOk()
    {
        return $this->ok;
    }
}
