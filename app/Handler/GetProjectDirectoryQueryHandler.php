<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Query\GetProjectDirectoryQuery;

/**
 * Class GetProjectDirectoryQueryHandler
 *
 * @package Gitamine\Handler
 */
class GetProjectDirectoryQueryHandler
{
    /**
     * @var GitamineConfig
     */
    private $gitamine;

    /**
     * GetProjectDirectoryQueryHandler constructor.
     *
     * @param GitamineConfig $gitamine
     */
    public function __construct(GitamineConfig $gitamine)
    {
        $this->gitamine = $gitamine;
    }

    /**
     * @param GetProjectDirectoryQuery $query
     *
     * @return string
     */
    public function __invoke(GetProjectDirectoryQuery $query): string
    {
        return $this->gitamine->getProjectFolder()->dir();
    }
}
