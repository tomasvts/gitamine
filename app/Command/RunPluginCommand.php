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
     * @var string
     */
    private $event;

    /**
     * RunPluginCommand constructor.
     *
     * @param string $plugin
     * @param string $event
     */
    public function __construct(string $plugin, string $event)
    {
        $this->plugin = $plugin;
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function plugin(): string
    {
        return $this->plugin;
    }

    /**
     * @return string
     */
    public function event(): string
    {
        return $this->event;
    }
}
