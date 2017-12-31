<?php
declare(strict_types=1);

namespace Gitamine\Test;

use Gitamine\Domain\Directory;
use Gitamine\Infrastructure\SubversionRepository;
use Hamcrest\Matchers;
use Mockery;
use Mockery\MockInterface;

/**
 * Class VersionControlMock
 *
 * @package Gitamine\Test
 */
class VersionControlMock
{
    /**
     * @var MockInterface
     */
    private $versionControl;

    public function __construct()
    {
        $this->versionControl = Mockery::mock(SubversionRepository::class);
    }

    /**
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return SubversionRepository
     */
    public function versionControl(): SubversionRepository
    {
        return $this->versionControl;
    }

    /**
     * @param string $dir
     * @param bool   $return
     */
    public function shouldBeValidVersionControlFolder(string $dir, bool $return): void
    {
        $this->versionControl->shouldReceive('isValidSubversionFolder')
                             ->once()
                             ->with(Matchers::equalTo(new Directory($dir)))
                             ->andReturn($return);
    }

    /**
     * @param string   $dir
     * @param string[] $return
     */
    public function shouldGetNewFiles(string $dir, array $return): void
    {
        $this->versionControl->shouldReceive('getNewFiles')
                             ->once()
                             ->with(Matchers::equalTo(new Directory($dir)))
                             ->andReturn($return);
    }

    /**
     * @param string   $dir
     * @param string[] $return
     */
    public function shouldGetModifiedFiles(string $dir, array $return): void
    {
        $this->versionControl->shouldReceive('getUpdatedFiles')
                             ->once()
                             ->with(Matchers::equalTo(new Directory($dir)))
                             ->andReturn($return);
    }

    /**
     * @param string   $dir
     * @param string[] $return
     */
    public function shouldGetDeletedFiles(string $dir, array $return): void
    {
        $this->versionControl->shouldReceive('getDeletedFiles')
                             ->once()
                             ->with(Matchers::equalTo(new Directory($dir)))
                             ->andReturn($return);
    }

    /**
     * @param string $dir
     * @param string $return
     */
    public function shouldGetRootDir(string $dir, string $return): void
    {
        $this->versionControl->shouldReceive('getRootDir')
                             ->once()
                             ->with(Matchers::equalTo(new Directory($dir)))
                             ->andReturn(new Directory($return));
    }
}
