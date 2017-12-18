<?php
declare(strict_types=1);

namespace Gitamine\Exception;

use Exception;
use Gitamine\Domain\Directory;
use Throwable;

/**
 * Class InvalidSubversionDirectoryException
 *
 * @package Gitamine\Exception
 */
class InvalidSubversionDirectoryException extends Exception
{
    /**
     * InvalidSubversionDirectoryException constructor.
     *
     * @param Directory      $dir
     * @param Throwable|null $previous
     */
    public function __construct(Directory $dir, Throwable $previous = null)
    {
        parent::__construct("Invalid subversion repository '{$dir->dir()}'", 1, $previous);
    }
}
