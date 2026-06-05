<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Startup;

use Rombt\ThemeCore\Composition\Contracts\BootstrapStepInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceComposerInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceRegistryInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\Composition\Planning\DependencyPlanBuilder;

final class EagerBootstrapStep implements BootstrapStepInterface
{
    public function __construct(
        private readonly ServiceRegistryInterface $registry,
        private readonly ServiceComposerInterface $composer,
    ) {
    }

    public function execute(): void
    {
        $plan = (new DependencyPlanBuilder())
            ->build($this->registry);

        foreach ($plan->getOrderedIdentifiers() as $identifier) {
            $definition = $this->registry->get($identifier);

            if ($definition->getLifecycle() !== ServiceLifecycle::EAGER) {
                continue;
            }

            $this->composer->get($identifier);
        }
    }
}
