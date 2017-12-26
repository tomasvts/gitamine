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
}
