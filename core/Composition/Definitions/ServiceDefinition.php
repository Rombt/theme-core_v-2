<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Definitions;

final class ServiceDefinition
{
    /**
     * @param string[] $dependencies
     */
    public function __construct(
        private string $identifier,
        private string $class,
        private string $lifecycle,
        private array $dependencies = []
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getLifecycle(): string
    {
        return $this->lifecycle;
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return $this->dependencies;
    }
}
