<?php
declare(strict_types=1);

namespace Gitamine\Domain;

/**
 * Class GithubPlugin
 *
 * @package Gitamine\Domain
 */
class GithubPlugin
{
    /**
     * @var GithubPluginName
     */
    private $name;

    /**
     * @var GithubPluginVersion
     */
    private $version;

    /**
     * GithubPlugin constructor.
     *
     * @param GithubPluginName    $name
     * @param GithubPluginVersion $version
     */
    public function __construct(GithubPluginName $name, GithubPluginVersion $version)
    {
        $this->name    = $name;
        $this->version = $version;
    }

    /**
     * @return GithubPluginName
     */
    public function name(): GithubPluginName
    {
        return $this->name;
    }

    /**
     * @return GithubPluginVersion
     */
    public function version(): GithubPluginVersion
    {
        return $this->version;
    }
}
