<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Query\GetGitamineDirectory;
use Gitamine\Query\GetProjectDirectory;
use React\Promise\Deferred;

/**
 * Class GetProjectDirectoryHandler
 *
 * @package Gitamine\Handler
 */
class GetProjectDirectoryHandler
{
    /**
     * @param GetProjectDirectory $query
     * @param Deferred|null       $deferred
     *
     * @return string
     */
    public function __invoke(GetProjectDirectory $query, Deferred $deferred = null): string
    {
        $dir = getcwd();

        if ($deferred) {
            $deferred->resolve($dir);
        }

        return $dir;
    }
}
