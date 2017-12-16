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
    private const GIT_ADDED    = 'git diff-index --cached --name-status HEAD | egrep \'^(A)\' | awk \'{print $2;}\'';
    private const GIT_MODIFIED = 'git diff-index --cached --name-status HEAD | egrep \'^(M)\' | awk \'{print $2;}\'';
    private const GIT_DELETED  = 'git diff-index --cached --name-status HEAD | egrep \'^(D)\' | awk \'{print $2;}\'';

    /**
     * @param Directory $dir
     *
     * @return bool
     */
    public function isValidSubversionFolder(Directory $dir): bool
    {
        try {
            $this->run($dir->dir(), 'git status');
            return true;
        } catch (InvalidSubversionDirectoryException $e) {
            return false;
        }
    }

    /**
     * @param Directory $dir
     *
     * @return string
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function getRootDir(Directory $dir): string
    {
        return $this->run($dir->dir(), self::GIT_ROOT)[0];
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
     */
    public function getDeletedFiles(Directory $dir): array
    {
        return $this->run($this->getRootDir($dir), self::GIT_DELETED);
    }

    /**
     * @param string $dir
     * @param string $command
     *
     * @return array
     */
    private function run(string $dir, string $command): array
    {
        $error  = 0;
        $output = [];

        exec(sprintf('cd %s 2> /dev/null ; %s 2> /dev/null', $dir, $command), $output, $error);

        if ($error) {
            throw new InvalidSubversionDirectoryException('Directory is not a Git Repository');
        }

        return $output;
    }
}
