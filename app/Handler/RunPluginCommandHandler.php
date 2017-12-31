<?php
declare(strict_types=1);

namespace Gitamine\Handler;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Command\RunPluginCommand;
use Gitamine\Domain\Directory;
use Gitamine\Domain\Event;
use Gitamine\Domain\Plugin;
use Gitamine\Exception\PluginExecutionFailedException;
use Gitamine\Infrastructure\GitamineConfig;
use Gitamine\Infrastructure\Output;
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
     * @var Output
     */
    private $output;

    /**
     * RunPluginCommandHandler constructor.
     *
     * @param SynchronousQueryBus $bus
     * @param GitamineConfig      $gitamine
     * @param Output              $output
     */
    public function __construct(SynchronousQueryBus $bus, GitamineConfig $gitamine, Output $output)
    {
        $this->bus      = $bus;
        $this->gitamine = $gitamine;
        $this->output   = $output;
    }

    /**
     * @param RunPluginCommand $query
     *
     * @throws PluginExecutionFailedException
     */
    public function __invoke(RunPluginCommand $query)
    {
        $dir     = new Directory($this->bus->dispatch(new GetProjectDirectoryQuery()));
        $plugin  = new Plugin($query->plugin());
        $event   = new Event($query->event());

        $options = $this->gitamine->getOptionsForPlugin($dir, $plugin, $event);
        $result  = '';

        if ($options->enabled()) {
            $this->output->print(str_pad("<info>Running</info> {$plugin->name()}:", 36));
            $row = $this->output->getCurrentLine();
            $this->output->println('<pending> ◷</pending>');

            $success = $this->gitamine->runPlugin($plugin, $event, $options, $result);
            $nextRow = $this->output->getCurrentLine();
            $nextCol = $this->output->getCurrentColumn();

            if (!$success) {
                $this->output->moveTo($row, 0);
                $this->output->clearLine();
                $this->output->moveTo($row, 0);

                $this->output->println(
                    str_pad("<info>Running</info> {$plugin->name()}:", 36) .
                    "\t<fail>✘</fail>"
                );

                $this->output->moveTo($nextRow, $nextCol);

                throw new PluginExecutionFailedException('Failed', 2);
            }

            $this->output->moveTo($row, 0);
            $this->output->clearLine();
            $this->output->moveTo($row, 0);

            $this->output->println(
                str_pad("<info>Running</info> {$plugin->name()}:", 36) .
                "\t<success>✔</success>"
            );
        }
    }
}
