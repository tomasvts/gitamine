<?php
declare(strict_types=1);

namespace Gitamine\Query;

/**
 * Class FetchCommittedFiles
 *
 * @package Gitamine\Query
 */
class FetchCommittedFiles
{
    /**
     * @var string
     */
    private $dir;

    /**
     * FetchCommitedFiles constructor.
     *
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return string
     */
    public function dir(): string
    {
        return $this->dir;
    }
}
