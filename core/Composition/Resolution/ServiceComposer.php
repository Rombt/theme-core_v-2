<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Resolution;

use Rombt\ThemeCore\Composition\Contracts\ServiceComposerInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceFactoryInterface;
use Rombt\ThemeCore\Composition\Contracts\LifecycleManagerInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceRegistryInterface;
use Rombt\ThemeCore\Composition\Exceptions\CompositionCycleException;
use Rombt\ThemeCore\Composition\Contracts\DependencyResolverInterface;

final class ServiceComposer implements ServiceComposerInterface
{
    public function __construct(
        private ServiceRegistryInterface $registry,
        private DependencyResolverInterface $resolver,
        private ServiceFactoryInterface $factory,
        private LifecycleManagerInterface $lifecycleManager,
        private ResolutionContext $context,
    ) {
    }

    public function get(string $identifier): object
    {
        if ($this->context->hasInstance($identifier)) {
            return $this->context->getInstance($identifier);
        }

        if ($this->context->isResolving($identifier)) {
            throw new CompositionCycleException(
                "Cycle detected for service: {$identifier}"
            );
        }

        $this->context->push($identifier);
        $definition = $this->registry->get($identifier);

        $dependencies = [];
        foreach ($this->resolver->resolve($identifier) as $dependencyId) {
            $dependencies[] = $this->get($dependencyId);
        }

        $instance = $this->factory->create(
            $definition->getClass(),
            $dependencies
        );

        if ($this->lifecycleManager->shouldStore($definition->getLifecycle())) {
            $this->context->storeInstance($identifier, $instance);
        }

        $this->context->pop();

        return $instance;
    }
}
