<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Common\Test\TestCase;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Handler\GetGitamineConfigurationQueryHandler;
use Gitamine\Query\GetGitamineConfigurationQuery;
use Gitamine\Test\GitamineMock;
use Gitamine\Test\VersionControlMock;

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
        $dir      = '/';
        $git      = VersionControlMock::create();
        $gitamine = GitamineMock::create();

        $git->shouldBeValidVersionControlFolder($dir, true);
        $git->shouldGetRootDir($dir, $dir);

        $gitamine->shouldGetConfiguration($dir, []);

        $handler = new GetGitamineConfigurationQueryHandler($git->versionControl(), $gitamine->gitamine());

        self::assertEquals([], $handler(new GetGitamineConfigurationQuery($dir)));
    }

    /**
     * @throws InvalidSubversionDirectoryException
     */
    public function testShouldThrowInvalidSubversionDirectoryException()
    {
        $this->expectException(InvalidSubversionDirectoryException::class);

        $dir      = '/';
        $git      = VersionControlMock::create();
        $gitamine = GitamineMock::create();

        $git->shouldBeValidVersionControlFolder($dir, false);

        $handler = new GetGitamineConfigurationQueryHandler($git->versionControl(), $gitamine->gitamine());
        $handler(new GetGitamineConfigurationQuery($dir));
    }
}
