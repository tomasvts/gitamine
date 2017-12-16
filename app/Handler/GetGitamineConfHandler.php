<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Domain\Directory;
use Gitamine\Exception\MissingGitamineConfigurationFileException;
use Gitamine\Infrastructure\SubversionRepository;
use Gitamine\Query\GetGitamineConf;
use React\Promise\Deferred;
use Symfony\Component\Yaml\Yaml;

/**
 * Class GetGitamineConfHandler
 *
 * @package Gitamine\Handler
 */
class GetGitamineConfHandler
{
    /**
     * @var SubversionRepository
     */
    private $repository;

    /**
     * GetGitamineConfHandler constructor.
     *
     * @param SubversionRepository $repository
     */
    public function __construct(SubversionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param GetGitamineConf $query
     * @param Deferred|null   $deferred
     *
     * @return array
     */
    public function __invoke(GetGitamineConf $query, Deferred $deferred = null): array
    {
        $dir = new Directory($query->dir());

        if (!$this->repository->isValidSubversionFolder($dir)) {
            throw new InvalidSubversionDirectoryException($dir, 1);
        }

        $root = $this->repository->getRootDir($dir);

        if (!is_file($root . '/.gitamine.yaml')) {
            throw new MissingGitamineConfigurationFileException('Missign gitamine.yaml file in root folder');
        }

        // TODO GitamineReader ?
        $conf = Yaml::parseFile($root . '/.gitamine.yaml')['gitamine'];

        if ($deferred) {
            $deferred->resolve($conf);
        }

        return $conf;
    }
}
