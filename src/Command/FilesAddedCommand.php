<?php
declare(strict_types=1);

namespace App\Command;

use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Query\FetchAddedFiles;
use Gitamine\Query\GetProjectDirectory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FilesAddedCommand
 *
 * @package App\Command
 */
class FilesAddedCommand extends ContainerAwareCommand
{
    protected function configure(): void
    {
        $this
            ->setName('files:added')
            ->setDescription('added files')
            ->setHelp('added files');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $projectDir = $this->getProjectDirectory();
            $files      = $this->getAddedFiles($projectDir);

            foreach ($files as $file) {
                $output->writeln($file);
            }
        } catch (InvalidSubversionDirectoryException $e) {
            return $e->getCode();
        }

        return 0;
    }

    /**
     * @param string $dir
     *
     * @return string[]
     */
    protected function getAddedFiles(string $dir): array
    {
        return $this->getContainer()
                    ->get('prooph_service_bus.gitamine_query_bus')
                    ->dispatch(new FetchAddedFiles($dir));
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
}
