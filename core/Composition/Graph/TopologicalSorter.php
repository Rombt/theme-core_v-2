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
        $visited = [];
        $visiting = [];
        $result = [];

        foreach ($graph->all() as $node) {
            $this->visit($node->getIdentifier(), $graph, $visited, $visiting, $result);
        }

        //todo здесь не уверен, тестировать
        // return array_reverse($result);
        return $result;
    }

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
