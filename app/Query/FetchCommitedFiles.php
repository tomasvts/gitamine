<?php
declare(strict_types=1);

namespace Gitamine\Query;

/**
 * Class FetchCommitedFiles
 *
 * @package Gitamine\Query
 */
class FetchCommitedFiles
{
    /**
     * @var string
     */
    private $name;

    /**
     * FetchCommitedFiles constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}
