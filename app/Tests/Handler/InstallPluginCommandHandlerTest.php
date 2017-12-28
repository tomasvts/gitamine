<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Command\InstallPluginCommand;
use Gitamine\Command\RunPluginCommand;
use Gitamine\Domain\Directory;
use Gitamine\Domain\Event;
use Gitamine\Domain\GithubPlugin;
use Gitamine\Domain\GithubPluginName;
use Gitamine\Domain\GithubPluginVersion;
use Gitamine\Domain\Plugin;
use Gitamine\Domain\PluginOptions;
use Gitamine\Exception\PluginExecutionFailedException;
use Gitamine\Handler\InstallPluginCommandHandler;
use Gitamine\Handler\RunPluginCommandHandler;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Infrastructure\Output;
use Gitamine\Query\GetProjectDirectoryQuery;
use Hamcrest\Matchers;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class RunPluginCommandHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class InstallPluginCommandHandlerTest extends TestCase
{
    public function testShouldInstallPlugin()
    {
        $dir = '/';

        $gitamine = Mockery::mock(GitamineConfig::class);
        $output   = Mockery::spy(Output::class);

        $gitamine->shouldReceive('getGitamineFolder')
                 ->once()
                 ->with()
                 ->andReturn(new Directory($dir));

        $gitamine->shouldReceive('getGithubPluginName')
                 ->once()
                ->with(Matchers::equalTo(new GithubPlugin(
                    new GithubPluginName('test/test'),
                    new GithubPluginVersion('master')
                )))
                ->andReturn('');

        $handler = new InstallPluginCommandHandler($gitamine, $output);
        $handler(new InstallPluginCommand('test/test', 'master'));

        self::assertTrue(true);
    }
}
