<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Domain\Directory;
use Gitamine\Domain\Event;
use Gitamine\Exception\InvalidFileException;
use Gitamine\Exception\InvalidGitamineProjectException;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Query\GetConfiguratedPluginsQuery;
use Gitamine\Query\GetProjectDirectoryQuery;

/**
 * Class GetConfiguratedPluginsQueryHandler
 *
 * @package Gitamine\Handler
 */
class GetConfiguratedPluginsQueryHandler
{
    /**
     * @var GitamineConfig
     */
    private $gitamine;

    /**
     * @var SynchronousQueryBus
     */
    private $bus;

    /**
     * GetConfiguratedPluginsQueryHandler constructor.
     *
     * @param SynchronousQueryBus $bus
     * @param GitamineConfig      $gitamine
     */
    public function __construct(SynchronousQueryBus $bus, GitamineConfig $gitamine)
    {
        $this->gitamine = $gitamine;
        $this->bus      = $bus;
    }

    /**
     * @param GetConfiguratedPluginsQuery $query
     *
     * @return string[]
     */
    public function __invoke(GetConfiguratedPluginsQuery $query): array
    {
        $dir     = new Directory($this->bus->dispatch(new GetProjectDirectoryQuery()));
        $plugins = $this->gitamine->getPluginList($dir, new Event($query->event()));
        $list    = [];

        foreach ($plugins as $plugin) {
            $list[] = $plugin->name();
        }

        return $list;
    }
}
