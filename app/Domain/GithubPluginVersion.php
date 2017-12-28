<?php
declare(strict_types=1);

namespace Gitamine\Domain;

/**
 * Class GithubPluginVersion
 *
 * @package Gitamine\Domain
 */
class GithubPluginVersion
{
    /**
     * @var string
     */
    private $version;

    /**
     * GithubPluginVersion constructor.
     *
     * @param string $version
     */
    public function __construct(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }
}
