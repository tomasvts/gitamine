<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Command\RunPluginCommand;
use Gitamine\Domain\Directory;
use Gitamine\Domain\Plugin;
use Gitamine\Domain\PluginOptions;
use Gitamine\Exception\PluginExecutionFailedException;
use Gitamine\Handler\RunPluginCommandHandler;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Query\GetProjectDirectoryQuery;
use Hamcrest\Matchers;
use PHPUnit\Framework\TestCase;

/**
 * Class RunPluginCommandHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class RunPluginCommandHandlerTest extends TestCase
{
    /**
     * @throws PluginExecutionFailedException
     */
    public function testShouldRunPlugin()
    {
        $dir = '/';

        $bus      = \Mockery::mock(SynchronousQueryBus::class);
        $gitamine = \Mockery::mock(GitamineConfig::class);

        $bus->shouldReceive('dispatch')
            ->once()
            ->with(Matchers::equalTo(new GetProjectDirectoryQuery()))
            ->andReturn($dir);

        $gitamine->shouldReceive('getOptionsForPlugin')
                 ->once()
                 ->with(Matchers::anInstanceOf(Directory::class), Matchers::equalTo(new Plugin('test')))
                 ->andReturn(new PluginOptions([]));

        $gitamine->shouldReceive('runPlugin')
                 ->once()
                 ->with(Matchers::equalTo(new Plugin('test')), Matchers::anInstanceOf(PluginOptions::class))
                 ->andReturn(true);

        $handler = new RunPluginCommandHandler($bus, $gitamine);
        $handler(new RunPluginCommand('test'));

        self::assertTrue(true);
    }

    /**
     * @throws PluginExecutionFailedException
     */
    public function testShouldThrowInvalidSubversionDirectoryException()
    {
        $this->expectException(PluginExecutionFailedException::class);

        $dir = '/';

        $bus      = \Mockery::mock(SynchronousQueryBus::class);
        $gitamine = \Mockery::mock(GitamineConfig::class);

        $bus->shouldReceive('dispatch')
            ->once()
            ->with(Matchers::equalTo(new GetProjectDirectoryQuery()))
            ->andReturn($dir);

        $gitamine->shouldReceive('getOptionsForPlugin')
                 ->once()
                 ->with(Matchers::anInstanceOf(Directory::class), Matchers::equalTo(new Plugin('test')))
                 ->andReturn(new PluginOptions([]));

        $gitamine->shouldReceive('runPlugin')
                 ->once()
                 ->with(Matchers::equalTo(new Plugin('test')), Matchers::anInstanceOf(PluginOptions::class))
                 ->andReturn(false);

        $handler = new RunPluginCommandHandler($bus, $gitamine);
        $handler(new RunPluginCommand('test'));
    }
}
