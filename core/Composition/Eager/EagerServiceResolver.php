<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Eager;

use Rombt\ThemeCore\Composition\Contracts\EagerServiceResolverInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceComposerInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceRegistryInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;

final class EagerServiceResolver implements EagerServiceResolverInterface
{
    public function __construct(
        private readonly ServiceRegistryInterface $registry,
        private readonly ServiceComposerInterface $composer,
    ) {
    }

    public function resolve(): void
    {
        foreach ($this->registry->all() as $definition) {
            if ($definition->getLifecycle() !== ServiceLifecycle::EAGER) {
                continue;
            }

            $this->composer->get($definition->getIdentifier());
        }
    }
}
