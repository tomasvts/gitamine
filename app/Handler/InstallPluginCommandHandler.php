<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Command\InstallPluginCommand;
use Gitamine\Domain\GithubPlugin;
use Gitamine\Domain\GithubPluginName;
use Gitamine\Domain\GithubPluginVersion;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Infrastructure\Output;

/**
 * Class InstallPluginCommandHandler
 *
 * @package Gitamine\Handler
 */
class InstallPluginCommandHandler
{
    /**
     * @var GitamineConfig
     */
    private $gitamine;

    /**
     * @var Output
     */
    private $output;

    /**
     * InstallPluginCommandHandler constructor.
     *
     * @param GitamineConfig $gitamine
     * @param Output         $output
     */
    public function __construct(GitamineConfig $gitamine, Output $output)
    {
        $this->gitamine = $gitamine;
        $this->output   = $output;
    }

    /**
     * @param InstallPluginCommand $command
     */
    public function __invoke(InstallPluginCommand $command)
    {
        $dir    = $this->gitamine->getGitamineFolder();
        $plugin = new GithubPlugin(
            new GithubPluginName($command->name()),
            new GithubPluginVersion($command->version())
        );
        $this->gitamine->getGithubPluginName($plugin);
    }
}
