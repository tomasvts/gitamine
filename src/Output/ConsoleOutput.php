<?php
declare(strict_types=1);

namespace App\Output;

use Gitamine\Infrastructure\Output;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput as SymfonyConsoleOutput;

/**
 * Class ConsoleOutput
 *
 * @package App\Output
 */
class ConsoleOutput implements Output
{
    protected $output;

    public function __construct()
    {
        $this->output = new SymfonyConsoleOutput();

        $style = new OutputFormatterStyle('green', null, ['bold']);
        $this->output->getFormatter()->setStyle('success', $style);

        $style = new OutputFormatterStyle('red', null, ['bold']);
        $this->output->getFormatter()->setStyle('fail', $style);

        $style = new OutputFormatterStyle('blue', null, ['bold', 'blink']);
        $this->output->getFormatter()->setStyle('pending', $style);
    }

    /**
     * @param string $message
     */
    public function print(string $message): void
    {
        $this->output->write($message);
    }

    /**
     * @param string $message
     */
    public function println(string $message): void
    {
        $this->output->writeln($message);
    }

    /**
     * @param string $message
     */
    public function printError(string $message): void
    {
        $this->output->getErrorOutput()->writeln("$message");
    }

    /**
     * @return int
     */
    public function getCurrentLine(): int
    {
        $command = '
            #!/bin/bash
            exec < /dev/tty
            oldstty=$(stty -g)
            stty raw -echo min 0
            printf "\033[6n" > /dev/tty
            IFS=\';\' read -r -d R -a pos
            stty $oldstty
            row=$((${pos[0]:2} - 1))    # strip off the esc-[
            echo $row
        ';

        $line = shell_exec($command);
        return (int) $line;
    }

    /**
     * @return int
     */
    public function getCurrentColumn(): int
    {
        $command = '
            #!/bin/bash
            exec < /dev/tty
            oldstty=$(stty -g)
            stty raw -echo min 0
            printf "\033[6n" > /dev/tty
            IFS=\';\' read -r -d R -a pos
            stty $oldstty
            col=$((${pos[1]} - 1))
            echo $col
        ';

        $col = shell_exec($command);
        return (int) $col;
    }

    /**
     * @param int $row
     * @param int $col
     */
    public function moveTo(int $row, int $col): void
    {
        system(sprintf('tput cup %d %d', $row, $col));
    }

    public function clearLine(): void
    {
        system('printf "%${COLUMNS}s" ""');
    }
}
