<?php
declare(strict_types=1);

namespace App\Command;

use App\Prooph\SynchronousQueryBus;
use Gitamine\Exception\InvalidSubversionDirectoryException;
use Gitamine\Query\FetchModifiedFilesQuery;
use Gitamine\Query\GetProjectDirectoryQuery;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FilesModifiedCommand
 *
 * @package App\Command
 */
class FilesModifiedCommand extends ContainerAwareCommand
{
    /**
     * @var SynchronousQueryBus;
     */
    private $bus;

    protected function configure(): void
    {
        $this
            ->setName('files:modified')
            ->setDescription('mod files')
            ->setHelp('mod files');
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

        try {
            $projectDir = $this->getProjectDirectory();
            $files      = $this->getModifiedFiles($projectDir);
            sort($files);

            foreach ($files as $file) {
                $output->writeln($file);
            }
        } catch (InvalidSubversionDirectoryException $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");

            return $e->getCode();
        }

        return 0;
    }

    /**
     * @param string $dir
     *
     * @return string[]
     */
    protected function getModifiedFiles(string $dir): array
    {
        return $this->bus->dispatch(new FetchModifiedFilesQuery($dir));
    }

    /**
     * @return string
     */
    protected function getProjectDirectory(): string
    {
        return $this->bus->dispatch(new GetProjectDirectoryQuery());
    }
}
