<?php
declare(strict_types=1);

namespace Gitamine\Command;

/**
 * Class RunPluginCommand
 *
 * @package Gitamine\Command
 */
class RunPluginCommand
{
    /**
     * @var string
     */
    private $plugin;

    /**
     * RunPluginCommand constructor.
     *
     * @param string $plugin
     */
    public function __construct(string $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return string
     */
    public function getPlugin(): string
    {
        return $this->plugin;
    }
}
