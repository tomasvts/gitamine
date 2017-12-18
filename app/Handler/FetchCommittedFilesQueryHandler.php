<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Infrastructure\InvalidSubversionCommand;
use Gitamine\Infrastructure\InvalidSubversionDirectory;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\FetchCommittedFilesQuery;

/**
 * Class FetchCommittedFilesQueryHandler
 *
 * @package Gitamine\Handler
 */
class FetchCommittedFilesQueryHandler
{
    /**
     * @var SubversionRepository
     */
    private $repository;

    /**
     * FetchCommittedFilesQueryHandler constructor.
     *
     * @param SubversionRepository $repository
     */
    public function __construct(SubversionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FetchCommittedFilesQuery $query
     *
     * @return string[]
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function __invoke(FetchCommittedFilesQuery $query): array
    {
        $dir = new Directory($query->dir());

        if (!$this->repository->isValidSubversionFolder($dir)) {
            throw new InvalidSubversionDirectoryException($dir);
        }

        $newFiles     = $this->repository->getNewFiles($dir);
        $updatedFiles = $this->repository->getUpdatedFiles($dir);

        return array_merge($newFiles, $updatedFiles);
    }
}
