<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Handler\FetchDeletedFilesQueryHandler;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\FetchDeletedFilesQuery;
use Hamcrest\Matchers;
use PHPUnit\Framework\TestCase;

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
        $dir = '/';

        $repo = \Mockery::mock(SubversionRepository::class);

        $repo->shouldReceive('isValidSubversionFolder')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn(true);

        $repo->shouldReceive('getDeletedFiles')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn([
                 '/deleted.txt'
             ]);

        $handler = new FetchDeletedFilesQueryHandler($repo);
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

        $dir = '/';

        $repo = \Mockery::mock(SubversionRepository::class);

        $repo->shouldReceive('isValidSubversionFolder')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn(false);

        $handler = new FetchDeletedFilesQueryHandler($repo);
        self::assertEquals(
            ['/deleted.txt'],
            $handler(new FetchDeletedFilesQuery($dir))
        );
    }
}
