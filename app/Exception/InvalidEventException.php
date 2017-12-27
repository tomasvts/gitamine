<?php
declare(strict_types=1);

namespace Gitamine\Exception;

use RuntimeException;
use Throwable;

/**
 * Class InvalidEventException
 *
 * @package Gitamine\Exception
 */
class InvalidEventException extends RuntimeException
{
    /**
     * InvalidEventException constructor.
     *
     * @param string         $event
     * @param Throwable|null $previous
     */
    public function __construct(string $event, Throwable $previous = null)
    {
        parent::__construct("Invalid event '$event'", 1, $previous);
    }
}
