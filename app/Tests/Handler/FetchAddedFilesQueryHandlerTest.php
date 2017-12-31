<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Common\Test\TestCase;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Handler\FetchAddedFilesQueryHandler;
use Gitamine\Query\FetchAddedFilesQuery;
use Gitamine\Test\VersionControlMock;

/**
 * Class FetchAddedFilesQueryHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class FetchAddedFilesQueryHandlerTest extends TestCase
{
    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testShouldFetchAddedFiles()
    {
        $dir   = '/';
        $files = ['/test.txt'];

        $repo = VersionControlMock::create();

        $repo->shouldBeValidVersionControlFolder($dir, true);
        $repo->shouldGetNewFiles($dir, $files);

        $handler = new FetchAddedFilesQueryHandler($repo->versionControl());
        self::assertEquals(
            $files,
            $handler(new FetchAddedFilesQuery($dir))
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

        $handler = new FetchAddedFilesQueryHandler($repo->versionControl());
        $handler(new FetchAddedFilesQuery($dir));
    }
}
