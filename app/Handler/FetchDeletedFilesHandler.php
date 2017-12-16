<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Infrastructure\InvalidSubversionCommand;
use Gitamine\Infrastructure\InvalidSubversionDirectory;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\FetchDeletedFiles;
use React\Promise\Deferred;

/**
 * Class FetchDeletedFilesHandler
 *
 * @package Gitamine\Handler
 */
class FetchDeletedFilesHandler
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
     * @param FetchDeletedFiles $query
     * @param Deferred|null   $deferred
     *
     * @return array
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function __invoke(FetchDeletedFiles $query, Deferred $deferred = null): array
    {
        $dir = new Directory($query->dir());

        if (!$this->repository->isValidSubversionFolder($dir)) {
            throw new InvalidSubversionDirectoryException($dir, 1);
        }

        $files = $this->repository->getDeletedFiles($dir);

        if ($deferred) {
            $deferred->resolve($files);
        }

        return $files;
    }
}
