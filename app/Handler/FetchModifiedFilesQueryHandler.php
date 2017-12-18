<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Infrastructure\InvalidSubversionCommand;
use Gitamine\Infrastructure\InvalidSubversionDirectory;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\FetchModifiedFilesQuery;

/**
 * Class FetchModifiedFilesQueryHandler
 *
 * @package Gitamine\Handler
 */
class FetchModifiedFilesQueryHandler
{
    /**
     * @var SubversionRepository
     */
    private $repository;

    /**
     * FetchCommitedFilesHandler constructor.
     *
     * @param SubversionRepository $repository
     */
    public function __construct(SubversionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FetchModifiedFilesQuery $query
     *
     * @return array
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function __invoke(FetchModifiedFilesQuery $query): array
    {
        $dir = new Directory($query->dir());

        if (!$this->repository->isValidSubversionFolder($dir)) {
            throw new InvalidSubversionDirectoryException($dir);
        }

        return $this->repository->getUpdatedFiles($dir);
    }
}
