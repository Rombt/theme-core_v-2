<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Graph;

use Rombt\ThemeCore\Composition\Exceptions\CompositionCycleException;

final class TopologicalSorter
{
    /**
     * @return string[]
     */
    public function sort(DependencyGraph $graph): array
    {
        /** @var array<string, true> $visited */
        $visited = [];

        /** @var array<string, true> $visiting */
        $visiting = [];

        /** @var string[] $result */
        $result = [];

        foreach ($graph->all() as $node) {
            $this->visit(
                $node->getIdentifier(),
                $graph,
                $visited,
                $visiting,
                $result
            );
        }

        // todo: уточнить необходимость reverse в тестах
        return $result;
    }

    /**
     * @param array<string, true> $visited
     * @param array<string, true> $visiting
     * @param string[] $result
     */
    private function visit(
        string $id,
        DependencyGraph $graph,
        array &$visited,
        array &$visiting,
        array &$result
    ): void {
        if (isset($visited[$id])) {
            return;
        }

        if (isset($visiting[$id])) {
            throw new CompositionCycleException(
                "Circular dependency detected at: {$id}"
            );
        }

        $visiting[$id] = true;

        $node = $graph->get($id);

        foreach ($node->getDependencies() as $dependency) {
            $this->visit($dependency, $graph, $visited, $visiting, $result);
        }

        unset($visiting[$id]);
        $visited[$id] = true;

        $result[] = $id;
    }
}
