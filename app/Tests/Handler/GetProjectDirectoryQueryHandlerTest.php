<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Common\Test\TestCase;
use Gitamine\Handler\GetProjectDirectoryQueryHandler;
use Gitamine\Query\GetProjectDirectoryQuery;
use Gitamine\Test\GitamineMock;

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
        $gitamine = GitamineMock::create();

        $gitamine->shouldGetProjectFolder($dir);

        $handler = new GetProjectDirectoryQueryHandler($gitamine->gitamine());
        self::assertEquals($dir, $handler(new GetProjectDirectoryQuery()));
    }
}
