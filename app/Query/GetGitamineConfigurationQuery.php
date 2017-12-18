<?php
declare(strict_types=1);

namespace Gitamine\Query;

/**
 * Class GetProjectDirectoryQuery
 *
 * @package Gitamine\Query
 */
class GetGitamineConfigurationQuery
{
    /**
     * @var string
     */
    private $dir;

    /**
     * GetGitamineConfigurationQuery constructor.
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
