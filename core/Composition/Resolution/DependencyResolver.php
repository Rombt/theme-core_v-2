<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Resolution;

use Rombt\ThemeCore\Composition\Contracts\DependencyResolverInterface;
use Rombt\ThemeCore\Composition\Graph\DependencyGraph;

final class DependencyResolver implements DependencyResolverInterface
{
    public function __construct(
        private readonly DependencyGraph $graph,
    ) {
    }

    public function resolve(string $identifier): array
    {
        return $this->graph
            ->get($identifier)
            ->getDependencies();
    }
}
