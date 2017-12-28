<?php
declare(strict_types=1);

namespace Gitamine\Domain;

use Gitamine\Exception\GithubProjectDoesNotExist;

/**
 * Class GithubPluginName
 *
 * @package Gitamine\Domain
 */
class GithubPluginName
{
    /**
     * @var string
     */
    private $plugin;

    /**
     * GithubPluginName constructor.
     *
     * @param string $plugin
     *
     * @throws GithubProjectDoesNotExist
     */
    public function __construct(string $plugin)
    {
        $this->plugin = $plugin;

        if (substr_count($plugin, '/') + 1 !== 2) {
            throw new GithubProjectDoesNotExist($plugin);
        }
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->plugin;
    }
}
