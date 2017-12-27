<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Command\RunPluginCommand;
use Gitamine\Domain\Directory;
use Gitamine\Domain\Event;
use Gitamine\Domain\Plugin;
use Gitamine\Domain\PluginOptions;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Exception\PluginExecutionFailedException;
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
class RunPluginCommandHandlerTest extends TestCase
{
    /**
     * @throws PluginExecutionFailedException
     */
    public function testShouldRunPlugin()
    {
        $dir = '/';

        $bus      = Mockery::mock(SynchronousQueryBus::class);
        $gitamine = Mockery::mock(GitamineConfig::class);
        $output   = Mockery::spy(Output::class);

        $bus->shouldReceive('dispatch')
            ->once()
            ->with(Matchers::equalTo(new GetProjectDirectoryQuery()))
            ->andReturn($dir);

        $gitamine->shouldReceive('getOptionsForPlugin')
                 ->once()
                ->with(
                    Matchers::anInstanceOf(Directory::class),
                    Matchers::equalTo(new Plugin('test')),
                    Matchers::equalTo(new Event(Event::PRE_COMMIT))
                )
                 ->andReturn(new PluginOptions([]));

        $gitamine->shouldReceive('runPlugin')
                 ->once()
                 ->with(Matchers::equalTo(new Plugin('test')), Matchers::anInstanceOf(PluginOptions::class), null)
                 ->andReturn(true);

        $handler = new RunPluginCommandHandler($bus, $gitamine, $output);
        $handler(new RunPluginCommand('test', 'pre-commit'));

        self::assertTrue(true);
    }

    /**
     * @throws PluginExecutionFailedException
     */
    public function testShouldThrowPluginExecutionFailedException()
    {
        $this->expectException(PluginExecutionFailedException::class);

        $dir = '/';

        $bus      = Mockery::mock(SynchronousQueryBus::class);
        $gitamine = Mockery::mock(GitamineConfig::class);
        $output   = Mockery::spy(Output::class);

        $bus->shouldReceive('dispatch')
            ->once()
            ->with(Matchers::equalTo(new GetProjectDirectoryQuery()))
            ->andReturn($dir);

        $gitamine->shouldReceive('getOptionsForPlugin')
                 ->once()
                ->with(
                    Matchers::anInstanceOf(Directory::class),
                    Matchers::equalTo(new Plugin('test')),
                    Matchers::equalTo(new Event('pre-commit'))
                )
                 ->andReturn(new PluginOptions([]));

        $gitamine->shouldReceive('runPlugin')
                 ->once()
                 ->with(Matchers::equalTo(new Plugin('test')), Matchers::anInstanceOf(PluginOptions::class), null)
                 ->andReturn(false);

        $handler = new RunPluginCommandHandler($bus, $gitamine, $output);
        $handler(new RunPluginCommand('test', 'pre-commit'));
    }
}
