<?php
declare(strict_types=1);

namespace Gitamine\Domain;

use Gitamine\Exception\PluginNotInstalledException;

/**
 * Class Plugin
 *
 * @package Gitamine\Domain
 */
class Plugin
{
    /**
     * @var string
     */
    private $name;

    /**
     * Plugin constructor.
     *
     * @param string $plugin
     *
     * @throws PluginNotInstalledException
     */
    public function __construct(string $plugin)
    {
        // TODO improve quelity
        if (!is_dir($_SERVER['HOME'] . '/.gitamine/plugins/' . $plugin)) {
            throw new PluginNotInstalledException("$plugin is not installed");
        }
        $this->name = $plugin;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}
