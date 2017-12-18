<?php
declare(strict_types=1);

namespace Gitamine\Tests\Domain;

use Gitamine\Domain\Plugin;
use Gitamine\Domain\PluginOptions;
use Gitamine\Exception\PluginNotInstalledException;
use PHPUnit\Framework\TestCase;

/**
 * Class PluginOptionsTest
 *
 * @package Gitamine\Tests\Domain
 */
class PluginOptionsTest extends TestCase
{
    public function testShouldBeTheSame()
    {
        self::assertEquals(
            ['a' => 1, 'b' => 3, 'enabled' => true],
            (new PluginOptions(['a' => 1, 'b' => 3]))->options()
        );
    }
}
