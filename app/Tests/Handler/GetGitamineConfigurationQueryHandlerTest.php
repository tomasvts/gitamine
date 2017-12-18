<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Handler\GetGitamineConfigurationQueryHandler;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\GetGitamineConfigurationQuery;
use Hamcrest\Matchers;
use PHPUnit\Framework\TestCase;

/**
 * Class GetConfiguratedPluginsQueryHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class GetGitamineConfigurationQueryHandlerTest extends TestCase
{
    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testGetConfiguratedPlugins()
    {
        $dir = '/';

        $repository = \Mockery::mock(SubversionRepository::class);
        $gitamine   = \Mockery::mock(GitamineConfig::class);

        $repository->shouldReceive('isValidSubversionFolder')
                   ->once()
                   ->with(Matchers::equalTo(new Directory($dir)))
                   ->andReturn(true);

        $repository->shouldReceive('getRootDir')
                   ->once()
                   ->with(Matchers::equalTo(new Directory($dir)))
                   ->andReturn(new Directory($dir));

        $gitamine->shouldReceive('getConfiguration')
                 ->once()
                 ->with(Matchers::equalTo(new Directory($dir)))
                 ->andReturn([]);

        $handler = new GetGitamineConfigurationQueryHandler($repository, $gitamine);

        self::assertEquals(
            [],
            $handler(new GetGitamineConfigurationQuery($dir))
        );
    }

    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testShouldThrowInvalidSubversionDirectoryException()
    {
        $this->expectException(InvalidSubversionDirectoryException::class);

        $repository = \Mockery::mock(SubversionRepository::class);
        $gitamine   = \Mockery::mock(GitamineConfig::class);

        $dir = '/';

        $repository->shouldReceive('isValidSubversionFolder')
             ->once()
             ->with(Matchers::equalTo(new Directory($dir)))
             ->andReturn(false);

        $handler = new GetGitamineConfigurationQueryHandler($repository, $gitamine);
        $handler(new GetGitamineConfigurationQuery($dir));
    }
}
