<?php
declare(strict_types=1);

namespace App\Command;

use Gitamine\Query\FetchCommittedFiles;
use Gitamine\Query\GetGitamineDirectory;
use Gitamine\Query\GetProjectDirectory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallPluginCommand
 *
 * @package App\Command
 */
class InstallPluginCommand extends ContainerAwareCommand
{
    protected function configure(): void
    {
        $this
            ->setName('install')
            ->setDescription('install')
            ->setHelp('install');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return 1;
    }
}
