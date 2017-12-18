<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Handler\GetProjectDirectoryQueryHandler;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Query\GetProjectDirectoryQuery;
use PHPUnit\Framework\TestCase;

/**
 * Class GetProjectDirectoryQueryHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class GetProjectDirectoryQueryHandlerTest extends TestCase
{
    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testGetGitamineCurrentDirectory(): void
    {
        $dir = '/';

        $gitamine = \Mockery::mock(GitamineConfig::class);

        $gitamine->shouldReceive('getProjectFolder')
                 ->once()
                 ->with()
                 ->andReturn(new Directory($dir));

        $handler = new GetProjectDirectoryQueryHandler($gitamine);

        self::assertEquals(
            '/',
            $handler(new GetProjectDirectoryQuery())
        );
    }
}
