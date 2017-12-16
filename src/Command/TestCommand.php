<?php
declare(strict_types=1);

namespace App\Command;

use Gitamine\Query\FetchCommitedFiles;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestCommand
 *
 * @package App\Command
 */
class TestCommand extends ContainerAwareCommand
{
    private $exitCode = 0;

    protected function configure(): void
    {
        $this
            ->setName('run')
            ->setDescription('run')
            ->setHelp('run');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // TODO 1. read configuration files

        $this->getContainer()
             ->get('prooph_service_bus.gitamine_query_bus')
             ->dispatch(new FetchCommitedFiles('World'))
             ->then(function (int $status) {
                 $this->end($status);
             });

        return 0;
    }

    /**
     * @param int $status
     */
    protected function end(int $status): void
    {
        echo $status . PHP_EOL;
    }
}
