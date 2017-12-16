<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use Gitamine\Query\FetchCommitedFiles;
use React\Promise\Deferred;

/**
 * Class FetchCommitedFilesHandler
 *
 * @package Gitamine\Handler
 */
class FetchCommitedFilesHandler
{
    /**
     * @param FetchCommitedFiles $query
     *
     * @param Deferred|null      $deferred
     *
     * @return int
     */
    public function __invoke(FetchCommitedFiles $query, Deferred $deferred = null): int
    {
        echo 'Hello ' . $query->name() . '!' . PHP_EOL;
        echo 'Home:' . $_SERVER['HOME'] . PHP_EOL;

        if ($deferred) {
            $deferred->resolve(0);
        }

        return 0;
    }
}
