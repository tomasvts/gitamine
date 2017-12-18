<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Domain\Directory;
use Gitamine\Domain\Plugin;
use Gitamine\Handler\GetConfiguratedPluginsQueryHandler;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Query\GetConfiguratedPluginsQuery;
use Gitamine\Query\GetProjectDirectoryQuery;
use Hamcrest\Matchers;
use PHPUnit\Framework\TestCase;

/**
 * Class GetConfiguratedPluginsQueryHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class GetConfiguratedPluginsQueryHandlerTest extends TestCase
{
    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testGetConfiguratedPlugins()
    {
        $dir = '/';

        $bus      = \Mockery::mock(SynchronousQueryBus::class);
        $gitamine = \Mockery::mock(GitamineConfig::class);

        $bus->shouldReceive('dispatch')
            ->once()
            ->with(Matchers::equalTo(new GetProjectDirectoryQuery()))
            ->andReturn($dir);

        $gitamine->shouldReceive('getPluginList')
                 ->once()
                 ->with(Matchers::equalTo(new Directory($dir)))
                 ->andReturn([new Plugin('phpunit')]);

        $handler = new GetConfiguratedPluginsQueryHandler($bus, $gitamine);

        self::assertEquals(
            ['phpunit'],
            $handler(new GetConfiguratedPluginsQuery())
        );
    }
}
