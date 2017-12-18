<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Handler\GetGitamineDirectoryQueryHandler;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Query\GetGitamineDirectoryQuery;
use PHPUnit\Framework\TestCase;

/**
 * Class GetGitamineDirectoryQueryHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class GetGitamineDirectoryQueryHandlerTest extends TestCase
{
    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testGetGitamineDirectory()
    {
        $gitamine = \Mockery::mock(GitamineConfig::class);

        $gitamine->shouldReceive('getGitamineFolder')
                 ->once()
                 ->with()
                 ->andReturn(new Directory('/'));

        $handler = new GetGitamineDirectoryQueryHandler($gitamine);

        self::assertEquals(
            '/',
            $handler(new GetGitamineDirectoryQuery())
        );
    }
}
