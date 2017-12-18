<?php
declare(strict_types=1);

namespace Gitamine\Domain;

/**
 * Class PluginOptions
 *
 * @package Gitamine\Domain
 */
class PluginOptions
{
    /**
     * @var array
     */
    private $options;

    /**
     * PluginOptions constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $options['enabled'] = $options['enabled'] ?? true;
        $this->options      = $options;
    }

    /**
     * @return bool
     */
    public function enabled(): bool
    {
        return $this->options['enabled'];
    }

    /**
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }
}
