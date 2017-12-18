<?php
declare(strict_types=1);

namespace Gitamine\Tests\Domain;

use Gitamine\Domain\Plugin;
use Gitamine\Exception\PluginNotInstalledException;
use PHPUnit\Framework\TestCase;

/**
 * Class PluginTest
 *
 * @package Gitamine\Tests\Domain
 */
class PluginTest extends TestCase
{
    public function testShouldThrowPluginNotInstalledException()
    {
        $this->expectException(PluginNotInstalledException::class);

        new Plugin(uniqid());
    }
}
