<?php
declare(strict_types=1);

namespace App\Command;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Command\InstallPluginCommand as InstallGitaminePluginCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallPluginCommand
 *
 * @package App\Command
 */
class InstallPluginCommand extends ContainerAwareCommand
{
    /**
     * @var SynchronousQueryBus;
     */
    private $bus;

    protected function configure(): void
    {
        $this
            ->setName('install')
            ->setDescription('installs a plugin')
            ->setHelp('TODO')
            ->addArgument('plugin', InputArgument::REQUIRED)
            ->addArgument('version', InputArgument::OPTIONAL, 'master');
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

        $this->bus = $this->getContainer()->get('prooph_service_bus.gitamine_query_bus');

        $plugin  = $input->getArgument('plugin');
        $version = $input->getArgument('version') ?? 'master';

        $this->bus->dispatch(new InstallGitaminePluginCommand($plugin, $version));
        return 1;
    }
}
