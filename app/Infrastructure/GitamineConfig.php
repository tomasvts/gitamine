<?php
declare(strict_types=1);

namespace Gitamine\Infrastructure;

use Gitamine\Domain\Directory;
use Gitamine\Domain\File;
use Gitamine\Domain\Hook;
use Gitamine\Domain\Plugin;
use Gitamine\Domain\PluginOptions;

/**
 * Interface GitamineConfig
 *
 * @package Gitamine\Infrastructure
 */
interface GitamineConfig
{
    /**
     * @param Directory $directory
     *
     * @return File
     */
    public function getConfigurationFile(Directory $directory): File;

    /**
     * @param Directory $directory
     *
     * @return array
     */
    public function getConfiguration(Directory $directory): array;

    /**
     * @param Plugin        $plugin
     * @param PluginOptions $pluginOptions
     *
     * @return bool
     */
    public function runPlugin(Plugin $plugin, PluginOptions $pluginOptions): bool;

    /**
     * @param Directory $directory
     *
     * @return Plugin[]
     */
    public function getPluginList(Directory $directory): array;

    /**
     * @param Directory $directory
     * @param Plugin    $plugin
     *
     * @return PluginOptions
     */
    public function getOptionsForPlugin(Directory $directory, Plugin $plugin): PluginOptions;

    /**
     * @return Directory
     */
    public function getGitamineFolder(): Directory;

    /**
     * @return array
     */
    public function getGitaminePlugins(): array;

    /**
     * @param Plugin $plugin
     *
     * @return Hook[]
     */
    public function getGitaminePluginHooks(Plugin $plugin): array;

    /**
     * @param Plugin $plugin
     *
     * @return File
     */
    public function getPluginExecutableFile(Plugin $plugin): File;

    /**
     * return the Directory which the project is located
     *
     * @return Directory
     */
    public function getProjectFolder(): Directory;
}
