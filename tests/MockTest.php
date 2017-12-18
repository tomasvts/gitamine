<?php
declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class MockTest
 *
 * @package App\Tests
 */
class MockTest extends TestCase
{
    public function testForceBehaviour()
    {
        self::pass();
    }

    public static function pass()
    {
        self::assertTrue(true);
    }
}
