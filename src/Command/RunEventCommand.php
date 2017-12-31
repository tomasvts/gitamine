<?php
declare(strict_types=1);

namespace App\Command;

use Gitamine\Command\RunPluginCommand;
use Gitamine\Exception\InvalidGitamineProjectException;
use Gitamine\Exception\PluginExecutionFailedException;
use Gitamine\Query\GetConfiguratedPluginsQuery;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RunEventCommand
 *
 * @package App\Command
 */
class RunEventCommand extends ContainerAwareCommand
{

    protected function configure(): void
    {
        $this
            ->setName('run')
            ->setDescription('run hook')
            ->setHelp('run hook')
            ->addArgument('hook', InputArgument::REQUIRED, 'Which hook to run');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            //$commandBus = $this->getContainer()->get('prooph_service_bus.gitamine_command_bus');
            $queryBus = $this->getContainer()->get('prooph_service_bus.gitamine_query_bus');
            $event    = $input->getArgument('hook');

            /** @var string[] $plugins */
            $plugins = $queryBus->dispatch(new GetConfiguratedPluginsQuery($event));

            foreach ($plugins as $plugin) {
                try {
                    $queryBus->dispatch(new RunPluginCommand($plugin, $event));
                } catch (PluginExecutionFailedException $e) {
                    return $e->getCode();
                }
            }
        } catch (InvalidGitamineProjectException $e) {
            return 1;
        }

        return 0;
    }
}
