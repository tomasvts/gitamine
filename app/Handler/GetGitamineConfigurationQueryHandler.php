<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\GetGitamineConfigurationQuery;

/**
 * Class GetGitamineConfigurationQueryHandler
 *
 * @package Gitamine\Handler
 */
class GetGitamineConfigurationQueryHandler
{
    /**
     * @var SubversionRepository
     */
    private $repository;

    /**
     * @var GitamineConfig
     */
    private $gitamine;

    /**
     * GetGitamineDirectoryQueryHandler constructor.
     *
     * @param SubversionRepository $repository
     * @param GitamineConfig       $gitamine
     */
    public function __construct(SubversionRepository $repository, GitamineConfig $gitamine)
    {
        $this->gitamine   = $gitamine;
        $this->repository = $repository;
    }

    /**
     * @param GetGitamineConfigurationQuery $query
     *
     * @return array
     *
     * @throws InvalidSubversionDirectoryException
     */
    public function __invoke(GetGitamineConfigurationQuery $query): array
    {
        $dir = new Directory($query->dir());

        if (!$this->repository->isValidSubversionFolder($dir)) {
            throw new InvalidSubversionDirectoryException($dir);
        }

        $root = $this->repository->getRootDir($dir);

        return $this->gitamine->getConfiguration($root);

        /*if (!is_file($root->dir() . '/gitamine.yaml')) {
            throw new MissingGitamineConfigurationFileException('Missign .gitanime/gitamine.yaml file in root folder');
        }*/
    }
}
