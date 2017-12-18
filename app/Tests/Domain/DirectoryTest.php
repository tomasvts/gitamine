<?php
declare(strict_types=1);

namespace Gitamine\Tests\Domain;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidDirException;
use Gitamine\Exception\InvalidFileException;
use PHPUnit\Framework\TestCase;

/**
 * Class DirectoryTest
 *
 * @package Gitamine\Tests\Domain
 */
class DirectoryTest extends TestCase
{

    public function testShouldWork()
    {
        $dir = (new Directory(__DIR__))->cd('../__assets');
        self::assertEquals('folder1', $dir->cd('folder1')->name());
        self::assertEquals($dir->dir() . '/file1.txt', $dir->open('file1.txt')->file());
        self::assertEquals('file1.txt', $dir->open('file1.txt')->name());
        self::assertEquals([$dir->open('file1.txt')], $dir->files());
        self::assertEquals([$dir->cd('folder1')], $dir->directories());
    }

    public function testShouldThrowInvalidDirException()
    {
        $this->expectException(InvalidDirException::class);
        new Directory('asd');
    }

    public function testShouldThrowInvalid()
    {
        $this->expectException(InvalidFileException::class);
        (new Directory(__DIR__))->open('anything');
    }
}
