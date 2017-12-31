<?php
declare(strict_types=1);

namespace Gitamine\Test;

use App\Prooph\SynchronousQueryBus;
use Hamcrest\Matchers;
use Mockery;
use Mockery\MockInterface;

/**
 * Class QueryBusMock
 *
 * @package Gitamine\Test
 */
class QueryBusMock
{
    /**
     * @var MockInterface
     */
    private $bus;

    public function __construct()
    {
        $this->bus = Mockery::mock(SynchronousQueryBus::class);
    }

    /**
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return SynchronousQueryBus
     */
    public function bus(): SynchronousQueryBus
    {
        return $this->bus;
    }

    /**
     * @param        $query
     * @param string $return
     */
    public function shouldDispatch($query, string $return): void
    {
        $this->bus->shouldReceive('dispatch')
                  ->once()
                  ->with(Matchers::equalTo($query))
                  ->andReturn($return);
    }
}
