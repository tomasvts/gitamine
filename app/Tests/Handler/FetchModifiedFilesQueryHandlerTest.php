<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Handler\FetchModifiedFilesQueryHandler;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\FetchModifiedFilesQuery;
use Hamcrest\Matchers;
use PHPUnit\Framework\TestCase;

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
        $dir = '/';

        $repo = \Mockery::mock(SubversionRepository::class);

        $repo->shouldReceive('isValidSubversionFolder')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn(true);

        $repo->shouldReceive('getUpdatedFiles')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn([
                 '/modified.txt'
             ]);

        $handler = new FetchModifiedFilesQueryHandler($repo);
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

        $repo = \Mockery::mock(SubversionRepository::class);

        $repo->shouldReceive('isValidSubversionFolder')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn(false);

        $handler = new FetchModifiedFilesQueryHandler($repo);
        self::assertEquals(
            ['/test.txt'],
            $handler(new FetchModifiedFilesQuery($dir))
        );
    }
}
