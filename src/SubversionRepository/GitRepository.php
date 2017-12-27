<?php
declare(strict_types=1);

namespace App\SubversionRepository;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Infrastructure\SubversionRepository;

/**
 * Class GitRepository
 *
 * @package App\SubversionRepository
 */
class GitRepository implements SubversionRepository
{
    private const GIT_ROOT     = 'git rev-parse --show-toplevel';
    private const GIT_ADDED    = 'git diff --cached --name-status | awk \'$1 == "A" { print $2 }\'';
    private const GIT_MODIFIED = 'git diff --cached --name-status | awk \'$1 == "M" { print $2 }\'';
    private const GIT_DELETED  = 'git diff --cached --name-status | awk \'$1 == "D" { print $2 }\'';

    /**
     * @param Directory $dir
     *
     * @return bool
     */
    public function isValidSubversionFolder(Directory $dir): bool
    {
        try {
            $this->run($dir, 'git status');
            return true;
        } catch (InvalidSubversionDirectoryException $e) {
            return false;
        }
    }

    /**
     * @param Directory $dir
     *
     * @return Directory
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function getRootDir(Directory $dir): Directory
    {
        return new Directory($this->run($dir, self::GIT_ROOT)[0]);
    }

    /**
     * @param Directory $dir
     *
     * @return array
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function getNewFiles(Directory $dir): array
    {
        return $this->run($this->getRootDir($dir), self::GIT_ADDED);
    }

    /**
     * @param Directory $dir
     *
     * @return array
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function getUpdatedFiles(Directory $dir): array
    {
        return $this->run($this->getRootDir($dir), self::GIT_MODIFIED);
    }

    /**
     * @param Directory $dir
     *
     * @return array
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function getDeletedFiles(Directory $dir): array
    {
        return $this->run($this->getRootDir($dir), self::GIT_DELETED);
    }

    /**
     * @param Directory $dir
     * @param string    $command
     *
     * @return array
     *
     * @throws InvalidSubversionDirectoryException
     */
    private function run(Directory $dir, string $command): array
    {
        $error  = 0;
        $output = [];

        exec(sprintf('cd %s 2> /dev/null ; %s 2> /dev/null', $dir->dir(), $command), $output, $error);

        if ($error) {
            throw new InvalidSubversionDirectoryException($dir);
        }

        return $output;
    }
}
