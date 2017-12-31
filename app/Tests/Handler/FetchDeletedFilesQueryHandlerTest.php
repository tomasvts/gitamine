<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Common\Test\TestCase;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Handler\FetchDeletedFilesQueryHandler;
use Gitamine\Query\FetchDeletedFilesQuery;
use Gitamine\Test\VersionControlMock;

/**
 * Class FetchDeletedFilesQueryHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class FetchDeletedFilesQueryHandlerTest extends TestCase
{

    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testShouldFetchAddedFiles()
    {
        $dir  = '/';
        $repo = VersionControlMock::create();

        $repo->shouldBeValidVersionControlFolder($dir, true);
        $repo->shouldGetDeletedFiles($dir, ['/deleted.txt']);

        $handler = new FetchDeletedFilesQueryHandler($repo->versionControl());
        self::assertEquals(
            ['/deleted.txt'],
            $handler(new FetchDeletedFilesQuery($dir))
        );
    }

    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testShouldThrowInvalidSubversionDirectoryException()
    {
        $this->expectException(InvalidSubversionDirectoryException::class);

        $dir  = '/';
        $repo = VersionControlMock::create();

        $repo->shouldBeValidVersionControlFolder($dir, false);

        $handler = new FetchDeletedFilesQueryHandler($repo->versionControl());
        self::assertEquals(
            ['/deleted.txt'],
            $handler(new FetchDeletedFilesQuery($dir))
        );
    }
}
