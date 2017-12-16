<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Infrastructure\InvalidSubversionCommand;
use Gitamine\Infrastructure\InvalidSubversionDirectory;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\FetchCommittedFiles;
use React\Promise\Deferred;

/**
 * Class FetchCommittedFilesHandler
 *
 * @package Gitamine\Handler
 */
class FetchCommittedFilesHandler
{
    /**
     * @var SubversionRepository
     */
    private $repository;

    /**
     * FetchCommittedFilesHandler constructor.
     *
     * @param SubversionRepository $repository
     */
    public function __construct(SubversionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FetchCommittedFiles $query
     * @param Deferred|null       $deferred
     *
     * @return string[]
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function __invoke(FetchCommittedFiles $query, Deferred $deferred = null): array
    {
        $dir = new Directory($query->dir());

        if (!$this->repository->isValidSubversionFolder($dir)) {
            throw new InvalidSubversionDirectoryException($dir, 1);
        }

        $newFiles     = $this->repository->getNewFiles($dir);
        $updatedFiles = $this->repository->getUpdatedFiles($dir);

        $files = array_merge($newFiles, $updatedFiles);

        if ($deferred) {
            $deferred->resolve($files);
        }

        return $files;
    }
}
