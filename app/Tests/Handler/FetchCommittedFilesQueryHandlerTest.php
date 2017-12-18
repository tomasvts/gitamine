<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Handler\FetchCommittedFilesQueryHandler;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\FetchCommittedFilesQuery;
use Hamcrest\Matchers;
use PHPUnit\Framework\TestCase;

/**
 * Class FetchCommittedFilesQueryHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class FetchCommittedFilesQueryHandlerTest extends TestCase
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
                 '/added.txt'
             ]);

        $repo->shouldReceive('getUpdatedFiles')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn([
                 '/modified.txt'
             ]);

        $handler = new FetchCommittedFilesQueryHandler($repo);
        self::assertEquals(
            ['/added.txt', '/modified.txt'],
            $handler(new FetchCommittedFilesQuery($dir))
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

        $handler = new FetchCommittedFilesQueryHandler($repo);
        self::assertEquals(
            ['/test.txt'],
            $handler(new FetchCommittedFilesQuery($dir))
        );
    }
}
