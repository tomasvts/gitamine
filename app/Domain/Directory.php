<?php
declare(strict_types=1);

namespace Gitamine\Domain;

use DirectoryIterator;
use Gitamine\Exception\InvalidDirException;

/**
 * Class Directory
 *
 * @package Gitamine\Domain
 */
class Directory
{
    /**
     * @var string
     */
    private $dir;

    /**
     * Directory constructor.
     *
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        if (!is_dir($dir)) {
            throw new InvalidDirException("Invalid dir '$dir'", 1);
        }

        $this->dir = realpath($dir);
    }

    /**
     * @return string
     */
    public function dir(): string
    {
        return $this->dir;
    }

    /**
     * @param string $folder
     *
     * @return Directory
     */
    public function cd(string $folder): self
    {
        return new Directory($this->dir() . '/' . $folder);
    }

    /**
     * @param string $file
     *
     * @return File
     */
    public function open(string $file): File
    {
        return new File($this->dir() . '/' . $file);
    }

    /**
     * @return Directory[]
     */
    public function directories(): array
    {
        $dirs = [];
        $dir  = new DirectoryIterator($this->dir());

        foreach ($dir as $fileInfo) {
            if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                $dirs[] = $this->cd($fileInfo->getFilename());
            }
        }

        return $dirs;
    }

    /**
     * @return File[]
     */
    public function files(): array
    {
        $files = [];
        $dir   = new DirectoryIterator($this->dir());

        foreach ($dir as $fileInfo) {
            if ($fileInfo->isFile() && !$fileInfo->isDot()) {
                $files[] = $this->open($fileInfo->getFilename());
            }
        }

        return $files;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return basename($this->dir());
    }
}
