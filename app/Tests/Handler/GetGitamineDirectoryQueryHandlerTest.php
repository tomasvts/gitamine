<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Common\Test\TestCase;
use Gitamine\Handler\GetGitamineDirectoryQueryHandler;
use Gitamine\Query\GetGitamineDirectoryQuery;
use Gitamine\Test\GitamineMock;

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
        $dir      = '/';
        $gitamine = GitamineMock::create();

        $gitamine->shouldGetGitamineFolder($dir);

        $handler = new GetGitamineDirectoryQueryHandler($gitamine->gitamine());
        self::assertEquals($dir, $handler(new GetGitamineDirectoryQuery()));
    }
}
