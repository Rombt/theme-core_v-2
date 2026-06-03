<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;

interface ServiceRegistryInterface
{
    public function register(ServiceDefinition $definition): void;

    public function has(string $identifier): bool;

    public function get(string $identifier): ServiceDefinition;

    /**
     * @return array<string, ServiceDefinition>
     */
    public function all(): array;
}
