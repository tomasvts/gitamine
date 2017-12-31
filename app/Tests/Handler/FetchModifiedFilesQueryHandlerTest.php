<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Common\Test\TestCase;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Handler\FetchModifiedFilesQueryHandler;
use Gitamine\Query\FetchModifiedFilesQuery;
use Gitamine\Test\VersionControlMock;

/**
 * Class FetchModifiedFilesQueryHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class FetchModifiedFilesQueryHandlerTest extends TestCase
{

    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testShouldFetchAddedFiles()
    {
        $dir  = '/';
        $repo = VersionControlMock::create();

        $repo->shouldBeValidVersionControlFolder($dir, true);
        $repo->shouldGetModifiedFiles($dir, ['/modified.txt']);

        $handler = new FetchModifiedFilesQueryHandler($repo->versionControl());
        self::assertEquals(
            ['/modified.txt'],
            $handler(new FetchModifiedFilesQuery($dir))
        );
    }

    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testShouldThrowInvalidSubversionDirectoryException()
    {
        $this->expectException(InvalidSubversionDirectoryException::class);

        $dir = '/';

        $repo = VersionControlMock::create();

        $repo->shouldBeValidVersionControlFolder($dir, false);

        $handler = new FetchModifiedFilesQueryHandler($repo->versionControl());
        $handler(new FetchModifiedFilesQuery($dir));
    }
}
