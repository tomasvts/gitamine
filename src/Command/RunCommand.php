<?php
declare(strict_types=1);

namespace App\Command;

use Gitamine\Query\FetchCommittedFiles;
use Gitamine\Query\GetGitamineConf;
use Gitamine\Query\GetGitamineDirectory;
use Gitamine\Query\GetProjectDirectory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RunCommand
 *
 * @package App\Command
 */
class RunCommand extends ContainerAwareCommand
{
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
        $gitamineDir  = $this->getGitamineDirectory();
        $projectDir   = $this->getProjectDirectory();
        $files        = $this->getCommitedFiles($projectDir);
        $gitamineConf = $this->getGitamineConf($projectDir);

        dump($files);
        dump($gitamineDir);
        dump($projectDir);
        dump($gitamineConf);

        return 1;
    }

    /**
     * @param string $dir
     *
     * @return string[]
     */
    protected function getCommitedFiles(string $dir): array
    {
        return $this->getContainer()
                    ->get('prooph_service_bus.gitamine_query_bus')
                    ->dispatch(new FetchCommittedFiles($dir));
    }

    /**
     * @return string
     */
    protected function getGitamineDirectory(): string
    {
        return $this->getContainer()
                    ->get('prooph_service_bus.gitamine_query_bus')
                    ->dispatch(new GetGitamineDirectory());
    }

    /**
     * @return string
     */
    protected function getProjectDirectory(): string
    {
        return $this->getContainer()
                    ->get('prooph_service_bus.gitamine_query_bus')
                    ->dispatch(new GetProjectDirectory());
    }

    /**
     * @param string $dir
     *
     * @return array
     */
    protected function getGitamineConf(string $dir): array
    {
        return $this->getContainer()
                    ->get('prooph_service_bus.gitamine_query_bus')
                    ->dispatch(new GetGitamineConf($dir));
    }
}
