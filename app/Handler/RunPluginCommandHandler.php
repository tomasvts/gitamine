<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Command\RunPluginCommand;
use Gitamine\Domain\Directory;
use Gitamine\Domain\Plugin;
use Gitamine\Exception\PluginExecutionFailedException;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Query\GetProjectDirectoryQuery;

/**
 * Class RunPluginCommandHandler
 *
 * @package Gitamine\Handler
 */
class RunPluginCommandHandler
{
    /**
     * @var SynchronousQueryBus
     */
    private $bus;

    /**
     * @var GitamineConfig
     */
    private $gitamine;

    /**
     * RunPluginCommandHandler constructor.
     *
     * @param SynchronousQueryBus $bus
     * @param GitamineConfig      $gitamine
     */
    public function __construct(SynchronousQueryBus $bus, GitamineConfig $gitamine)
    {
        $this->bus      = $bus;
        $this->gitamine = $gitamine;
    }

    /**
     * @param RunPluginCommand $query
     *
     * @throws PluginExecutionFailedException
     */
    public function __invoke(RunPluginCommand $query)
    {
        $dir     = new Directory($this->bus->dispatch(new GetProjectDirectoryQuery()));
        $plugin  = new Plugin($query->getPlugin());
        $options = $this->gitamine->getOptionsForPlugin($dir, $plugin);

        if ($options->enabled()) {
            $success = $this->gitamine->runPlugin($plugin, $options);

            if (!$success) {
                throw new PluginExecutionFailedException('Failed', 2);
            }
        }
    }
}
