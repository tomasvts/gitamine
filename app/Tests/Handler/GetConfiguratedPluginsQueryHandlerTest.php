<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Common\Test\TestCase;
use Gitamine\Handler\GetConfiguratedPluginsQueryHandler;
use Gitamine\Query\GetConfiguratedPluginsQuery;
use Gitamine\Query\GetProjectDirectoryQuery;
use Gitamine\Test\GitamineMock;
use Gitamine\Test\QueryBusMock;

/**
 * Class GetConfiguratedPluginsQueryHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class GetConfiguratedPluginsQueryHandlerTest extends TestCase
{
    public function testGetConfiguratedPlugins()
    {
        $dir      = '/';
        $bus      = QueryBusMock::create();
        $gitamine = GitamineMock::create();

        $bus->shouldDispatch(new GetProjectDirectoryQuery(), $dir);
        $gitamine->shouldGetPluginList($dir, 'pre-commit', ['test']);

        $handler = new GetConfiguratedPluginsQueryHandler($bus->bus(), $gitamine->gitamine());

        self::assertEquals(
            ['test'],
            $handler(new GetConfiguratedPluginsQuery('pre-commit'))
        );
    }
}
