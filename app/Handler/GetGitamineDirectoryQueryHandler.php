<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Query\GetGitamineDirectoryQuery;
use React\Promise\Deferred;

/**
 * Class GetGitamineDirectoryQueryHandler
 *
 * @package Gitamine\Handler
 */
class GetGitamineDirectoryQueryHandler
{
    /**
     * @var GitamineConfig
     */
    private $gitamine;

    /**
     * GetGitamineDirectoryQueryHandler constructor.
     *
     * @param GitamineConfig $gitamine
     */
    public function __construct(GitamineConfig $gitamine)
    {
        $this->gitamine = $gitamine;
    }

    /**
     * @param GetGitamineDirectoryQuery $query
     * @param Deferred|null             $deferred
     *
     * @return string
     */
    public function __invoke(GetGitamineDirectoryQuery $query, ?Deferred $deferred = null): string
    {
        return $this->gitamine->getGitamineFolder()->dir();
    }
}
