<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Registry;

use Rombt\ThemeCore\Composition\Contracts\ServiceRegistryInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Exceptions\CompositionDuplicateDefinitionException;
use Rombt\ThemeCore\Composition\Exceptions\CompositionDefinitionNotFoundException;

final class ServiceRegistry implements ServiceRegistryInterface
{
    /**
     * @var array<string, ServiceDefinition>
     */
    private array $definitions = [];

    public function register(ServiceDefinition $definition): void
    {

        if ($this->has($definition->getIdentifier())) {
            throw new CompositionDuplicateDefinitionException(
                sprintf(
                    'Service definition "%s" is already registered.',
                    $definition->getIdentifier()
                )
            );
        }

        $this->definitions[$definition->getIdentifier()] = $definition;
    }

    public function has(string $identifier): bool
    {
        return isset($this->definitions[$identifier]);
    }

    public function get(string $identifier): ServiceDefinition
    {
        if (!$this->has($identifier)) {
            throw new CompositionDefinitionNotFoundException(
                sprintf(
                    'Service definition "%s" was not found.',
                    $identifier
                )
            );
        }

        return $this->definitions[$identifier];
    }

    public function all(): array
    {
        return $this->definitions;
    }
}
