<?php
declare(strict_types=1);

namespace Gitamine\Tests\Domain;

use Gitamine\Domain\Directory;
use Gitamine\Domain\Event;
use Gitamine\Exception\InvalidDirException;
use Gitamine\Exception\InvalidEventException;
use Gitamine\Exception\InvalidFileException;
use PHPUnit\Framework\TestCase;

/**
 * Class EventTest
 *
 * @package Gitamine\Tests\Domain
 */
class EventTest extends TestCase
{

    public function testShouldWork()
    {
        $event = new Event('pre-commit');
        self::assertEquals('pre-commit', $event->event());
    }

    public function testShouldThrowInvalidEventException()
    {
        $this->expectException(InvalidEventException::class);
        new Event('asd');
    }
}
