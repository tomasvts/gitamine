<?php
declare(strict_types=1);

namespace Gitamine\Query;

/**
 * Class GetProjectDirectory
 *
 * @package Gitamine\Query
 */
class GetGitamineConf
{
    /**
     * @var string
     */
    private $dir;

    /**
     * GetGitamineConf constructor.
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
