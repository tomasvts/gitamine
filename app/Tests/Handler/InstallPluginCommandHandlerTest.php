<?php
declare(strict_types=1);

namespace Gitamine\Tests\Handler;

use Gitamine\Command\InstallPluginCommand;
use Gitamine\Common\Test\TestCase;
use Gitamine\Handler\InstallPluginCommandHandler;
use Gitamine\Test\GitamineMock;
use Gitamine\Test\OutputMock;

/**
 * Class RunPluginCommandHandlerTest
 *
 * @package Gitamine\Tests\Handler
 */
class InstallPluginCommandHandlerTest extends TestCase
{
    public function testShouldInstallPlugin()
    {
        $dir = '/';
        $gitamine = GitamineMock::create();
        $output   = OutputMock::create();

        $gitamine->shouldGetGitamineFolder($dir);
        $gitamine->shouldGetPluginName('test/test', 'master');

        $handler = new InstallPluginCommandHandler($gitamine->gitamine(), $output->output());
        $handler(new InstallPluginCommand('test/test', 'master'));
    }
}
