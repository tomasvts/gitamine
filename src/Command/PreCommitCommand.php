<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PreCommitCommand
 *
 * @package App\Command
 */
class PreCommitCommand extends ContainerAwareCommand
{
    protected function configure(): void
    {
        $this
            ->setName('pre-commit')
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
        return 0;
    }
}
