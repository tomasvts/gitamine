<?php
declare(strict_types=1);

namespace Gitamine\Tests\Domain;

use Gitamine\Domain\GithubPlugin;
use Gitamine\Domain\GithubPluginName;
use Gitamine\Domain\GithubPluginVersion;
use Gitamine\Exception\GithubProjectDoesNotExist;
use PHPUnit\Framework\TestCase;

/**
 * Class GithubPluginTest
 * @package Gitamine\Tests\Domain
 */
class GithubPluginTest extends TestCase
{

    public function testReturnValidValues()
    {
        $plugin = new GithubPlugin(
            new GithubPluginName('test/test'),
            new GithubPluginVersion('master')
        );

        self::assertEquals('test/test', $plugin->name()->name());
        self::assertEquals('master', $plugin->version()->version());
    }

    public function testShoulThrowGithubProjectDoesNotExistException()
    {
        $this->expectException(GithubProjectDoesNotExist::class);

        new GithubPlugin(
            new GithubPluginName('test'),
            new GithubPluginVersion('master')
        );
    }
}
