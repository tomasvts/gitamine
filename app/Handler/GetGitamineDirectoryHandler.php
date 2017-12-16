<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Query\GetGitamineDirectory;
use React\Promise\Deferred;

/**
 * Class GetGitamineDirectoryHandler
 *
 * @package Gitamine\Handler
 */
class GetGitamineDirectoryHandler
{
    /**
     * @param GetGitamineDirectory $query
     * @param Deferred|null        $deferred
     *
     * @return string
     */
    public function __invoke(GetGitamineDirectory $query, Deferred $deferred = null): string
    {
        $dir = $_SERVER['HOME'] . '/.gitamine';

        if ($deferred) {
            $deferred->resolve($dir);
        }

        return $dir;
    }
}
