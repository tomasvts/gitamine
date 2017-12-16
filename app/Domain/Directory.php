<?php
declare(strict_types=1);

namespace Gitamine\Domain;

use Gitamine\Exception\InvalidDirException;

/**
 * Class Directory
 *
 * @package Gitamine\Domain
 */
class Directory
{
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

        $this->dir = $dir;
    }

    /**
     * @return string
     */
    public function dir(): string
    {
        return $this->dir;
    }
}
