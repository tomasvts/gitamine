<?php
declare(strict_types=1);

namespace Gitamine\Command;

/**
 * Class InstallPluginCommand
 * @package Gitamine\Command
 */
class InstallPluginCommand
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $version;

    /**
     * InstallPluginCommand constructor.
     *
     * @param string $name
     * @param string $version
     */
    public function __construct(string $name, string $version)
    {
        $this->name    = $name;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }
}
