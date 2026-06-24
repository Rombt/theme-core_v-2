<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Registration;

use Rombt\ThemeCore\Composition\Contracts\ServiceRegistrarInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceRegistryInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceDefinitionProviderInterface;

final class ServiceRegistrar implements ServiceRegistrarInterface
{
    /**
     * @param ServiceDefinitionProviderInterface[] $providers
     */
    public function __construct(
        private readonly array $providers,
    ) {
    }

    public function register(ServiceRegistryInterface $registry): void
    {

        foreach ($this->providers as $provider) {
            foreach ($provider->provide() as $definition) {
                $registry->register($definition);
            }
        }
    }
}
