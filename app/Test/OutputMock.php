<?php
declare(strict_types=1);

namespace Gitamine\Test;

use Gitamine\Infrastructure\Output;
use Mockery;
use Mockery\MockInterface;

/**
 * Class OutputMock
 *
 * @package Gitamine\Test
 */
class OutputMock
{
    /**
     * @var MockInterface
     */
    private $output;

    public function __construct()
    {
        $this->output = Mockery::spy(Output::class);
    }

    /**
     * @return Output
     */
    public function output(): Output
    {
        return $this->output;
    }

    /**
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }
}
