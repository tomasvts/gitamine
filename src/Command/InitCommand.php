<?php
declare(strict_types=1);

namespace App\Command;

use App\Prooph\SynchronousQueryBus;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallPluginCommand
 *
 * @package App\Command
 */
class InitCommand extends ContainerAwareCommand
{
    /**
     * @var SynchronousQueryBus;
     */
    private $bus;

    protected function configure(): void
    {
        $this
            ->setName('init')
            ->setDescription('TODO')
            ->setHelp('TODO');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dir = __DIR__ . '/../..';
        system("echo 'gitamine run' > $dir/.git/hooks/pre-commit");

        // TODO just for easy start configuration purpose
        system('mkdir ~/.gitamine');
        system('mkdir ~/.gitamine/plugins');
        system('mkdir ~/.gitamine/plugins/test');
        system("echo '#!/usr/bin/env bash' > ~/.gitamine/plugins/test/run");
        system("echo 'echo hello world!' >> ~/.gitamine/plugins/test/run");
        system('chmod +x ~/.gitamine/plugins/test/run');
        system('chmod 755 ~/.gitamine/plugins/test/run');

        system('mkdir ~/.gitamine');
        system('mkdir ~/.gitamine/plugins');
        system('mkdir ~/.gitamine/plugins/phpcs');
        system("echo '#!/usr/bin/env bash' > ~/.gitamine/plugins/phpcs/run");
        system("echo 'FILES=\"$(gitamine f:c | grep php)\"' >> ~/.gitamine/plugins/phpcs/run");
        system("echo 'bin/phpcs --standard=PSR2 \$FILES' >> ~/.gitamine/plugins/phpcs/run");
        system('chmod +x ~/.gitamine/plugins/phpcs/run');
        system('chmod 755 ~/.gitamine/plugins/phpcs/run');

        system('mkdir ~/.gitamine');
        system('mkdir ~/.gitamine/plugins');
        system('mkdir ~/.gitamine/plugins/phpunit');
        system("echo '#!/usr/bin/env bash' > ~/.gitamine/plugins/phpunit/run");
        system("echo 'bin/phpunit' >> ~/.gitamine/plugins/phpunit/run");
        system('chmod +x ~/.gitamine/plugins/phpunit/run');
        system('chmod 755 ~/.gitamine/plugins/phpunit/run');

        system('mkdir ~/.gitamine');
        system('mkdir ~/.gitamine/plugins');
        system('mkdir ~/.gitamine/plugins/symfony');
        system("echo '#!/usr/bin/env bash' > ~/.gitamine/plugins/symfony/run");
        system("echo 'bin/phpunit' >> ~/.gitamine/plugins/symfony/run");
        system('chmod +x ~/.gitamine/plugins/symfony/run');
        system('chmod 755 ~/.gitamine/plugins/symfony/run');

        system('mkdir ~/.gitamine');
        system('mkdir ~/.gitamine/plugins');
        system('mkdir ~/.gitamine/plugins/phplint');
        system("echo '#!/usr/bin/env bash' > ~/.gitamine/plugins/phplint/run");
        system("echo 'FILES=\"$(gitamine f:c | grep php)\"' >> ~/.gitamine/plugins/phplint/run");
        system("echo 'bin/phplint \$FILES' >> ~/.gitamine/plugins/phplint/run");
        system('chmod +x ~/.gitamine/plugins/phplint/run');
        system('chmod 755 ~/.gitamine/plugins/phplint/run');

        $this->bus = $this->getContainer()->get('prooph_service_bus.gitamine_query_bus');

        return 1;
    }
}
