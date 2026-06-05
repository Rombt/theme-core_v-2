<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Planning;

use Rombt\ThemeCore\Composition\Graph\DependencyGraphBuilder;
use Rombt\ThemeCore\Composition\Graph\TopologicalSorter;
use Rombt\ThemeCore\Composition\Contracts\ServiceRegistryInterface;

final class DependencyPlanBuilder
{
    public function build(ServiceRegistryInterface $registry): DependencyPlan
    {
        $graph = (new DependencyGraphBuilder())->build($registry);

        $order = (new TopologicalSorter())->sort($graph);

        return new DependencyPlan($order);
    }
}
