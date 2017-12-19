<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Domain\Directory;
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
     *
     * @throws InvalidGitamineProjectException
     */
    public function __invoke(GetConfiguratedPluginsQuery $query): array
    {
        try {
            $dir     = new Directory($this->bus->dispatch(new GetProjectDirectoryQuery()));
            $plugins = $this->gitamine->getPluginList($dir);
            $list    = [];

            foreach ($plugins as $plugin) {
                $list[] = $plugin->name();
            }
        } catch (InvalidFileException $e) {
            throw new InvalidGitamineProjectException('Invalid gitamine folder', 1, $e);
        }

        return $list;
    }
}
