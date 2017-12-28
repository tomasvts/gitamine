<?php
declare(strict_types=1);

namespace Gitamine\Exception;

use Exception;
use Throwable;

/**
 * Class MissingConfigurationFileException
 * @package Gitamine\Exception
 */
class MissingConfigurationFileException extends Exception
{
    /**
     * MissingConfigurationFileException constructor.
     *
     * @param Throwable|null $previous
     */
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Missing gitamine.json file', 1, $previous);
    }
}
