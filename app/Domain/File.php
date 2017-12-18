<?php
declare(strict_types=1);

namespace Gitamine\Domain;

use Gitamine\Exception\InvalidDirException;
use Gitamine\Exception\InvalidFileException;

/**
 * Class Directory
 *
 * @package Gitamine\Domain
 */
class File
{
    /**
     * @var string
     */
    private $file;

    /**
     * File constructor.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        if (!is_file($file)) {
            throw new InvalidFileException("Invalid file '$file'", 1);
        }

        $this->file = $file;
    }

    /**
     * @return string
     */
    public function file(): string
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return basename($this->file());
    }
}
