<?php
declare(strict_types=1);

namespace Gitamine\Test;

use Gitamine\Domain\Directory;
use Gitamine\Domain\Event;
use Gitamine\Domain\GithubPlugin;
use Gitamine\Domain\GithubPluginName;
use Gitamine\Domain\GithubPluginVersion;
use Gitamine\Domain\Plugin;
use Gitamine\Domain\PluginOptions;
use Gitamine\Infrastructure\GitamineConfig;
use Hamcrest\Matchers;
use Mockery;
use Mockery\MockInterface;

/**
 * Class GitamineMock
 *
 * @package Gitamine\Test
 */
class GitamineMock
{
    /**
     * @var MockInterface
     */
    private $gitamine;

    public function __construct()
    {
        $this->gitamine = Mockery::mock(GitamineConfig::class);
    }

    /**
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return GitamineConfig
     */
    public function gitamine(): GitamineConfig
    {
        return $this->gitamine;
    }

    /**
     * @param string $plugin
     * @param string $event
     * @param array  $options
     */
    public function shouldGetOptionsForPlugin(string $plugin, string $event, array $options = []): void
    {
        $thePlugin    = Matchers::equalTo(new Plugin($plugin));
        $theEvent     = Matchers::equalTo(new Event($event));
        $theDirectory = Matchers::anInstanceOf(Directory::class);
        $this->gitamine->shouldReceive('getOptionsForPlugin')
                       ->once()
                       ->with($theDirectory, $thePlugin, $theEvent)
                       ->andReturn(new PluginOptions($options));
    }

    /**
     * @param string $plugin
     * @param string $event
     * @param bool   $return
     */
    public function shouldRunPlugin(string $plugin, string $event, bool $return): void
    {
        $thePlugin  = Matchers::equalTo(new Plugin($plugin));
        $theEvent   = Matchers::equalTo(new Event($event));
        $theOptions = Matchers::anInstanceOf(PluginOptions::class);
        $this->gitamine->shouldReceive('runPlugin')
                       ->once()
                       ->with($thePlugin, $theEvent, $theOptions, null)
                       ->andReturn($return);
    }

    /**
     * @param string   $dir
     * @param string   $event
     * @param string[] $return
     */
    public function shouldGetPluginList(string $dir, string $event, array $return): void
    {
        $plugins = [];
        foreach ($return as $plugin) {
            $plugins[] = new Plugin($plugin);
        }

        $this->gitamine->shouldReceive('getPluginList')
                       ->once()
                       ->with(Matchers::equalTo(new Directory($dir)), Matchers::equalTo(new Event($event)))
                       ->andReturn($plugins);
    }

    /**
     * @param string $dir
     * @param array  $return
     */
    public function shouldGetConfiguration(string $dir, array $return): void
    {
        $this->gitamine->shouldReceive('getConfiguration')
                       ->once()
                       ->with(Matchers::equalTo(new Directory($dir)))
                       ->andReturn($return);
    }

    /**
     * @param string $return
     */
    public function shouldGetGitamineFolder(string $return): void
    {
        $this->gitamine->shouldReceive('getGitamineFolder')
                       ->once()
                       ->with()
                       ->andReturn(new Directory($return));
    }

    /**
     * @param string $return
     */
    public function shouldGetProjectFolder(string $return): void
    {
        $this->gitamine->shouldReceive('getProjectFolder')
                       ->once()
                       ->with()
                       ->andReturn(new Directory($return));
    }

    /**
     * @param string $name
     * @param string $version
     * @param string $return
     */
    public function shouldGetPluginName(string $name, string $version, string $return = ''): void
    {
        $thePlugin = Matchers::equalTo(new GithubPlugin(
            new GithubPluginName($name),
            new GithubPluginVersion($version)
        ));
        $this->gitamine->shouldReceive('getGithubPluginName')
                       ->once()
                       ->with($thePlugin)
                       ->andReturn($return);
    }
}
