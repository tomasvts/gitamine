<?php
declare(strict_types=1);

namespace Gitamine\Infrastructure;

/**
 * Interface ConsoleOutput
 *
 * @package Gitamine\Infrastructure
 */
interface Output
{
    /**
     * @param string $message
     */
    public function print(string $message): void;

    /**
     * @param string $message
     */
    public function println(string $message): void;

    /**
     * @param string $message
     */
    public function printError(string $message): void;
}
