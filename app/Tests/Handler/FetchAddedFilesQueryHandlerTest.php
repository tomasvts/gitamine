<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Handler\FetchAddedFilesQueryHandler;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\FetchAddedFilesQuery;
use Hamcrest\Matchers;
use PHPUnit\Framework\TestCase;

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
        $dir = '/';

        $repo = \Mockery::mock(SubversionRepository::class);

        $repo->shouldReceive('isValidSubversionFolder')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn(true);

        $repo->shouldReceive('getNewFiles')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn([
                 '/test.txt'
             ]);

        $handler = new FetchAddedFilesQueryHandler($repo);
        self::assertEquals(
            ['/test.txt'],
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

        $repo = \Mockery::mock(SubversionRepository::class);

        $repo->shouldReceive('isValidSubversionFolder')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn(false);

        $handler = new FetchAddedFilesQueryHandler($repo);
        self::assertEquals(
            ['/test.txt'],
            $handler(new FetchAddedFilesQuery($dir))
        );
    }
}
