<?php
declare(strict_types=1);

namespace Gitamine\Infrastructure;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;

/**
 * Interface SubversionRepository
 *
 * @package Gitamine\Infrastructure
 */
interface SubversionRepository
{
    /**
     * @param Directory $dir
     *
     * @return bool
     */
    public function isValidSubversionFolder(Directory $dir): bool;

    /**
     * @param Directory $dir
     *
     * @return Directory
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function getRootDir(Directory $dir): Directory;

    /**
     * @param Directory $dir
     *
     * @return string[]
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function getNewFiles(Directory $dir): array;

    /**
     * @param Directory $dir
     *
     * @return string[]
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function getUpdatedFiles(Directory $dir): array;

    /**
     * @param Directory $dir
     *
     * @return string[]
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function getDeletedFiles(Directory $dir): array;
}
