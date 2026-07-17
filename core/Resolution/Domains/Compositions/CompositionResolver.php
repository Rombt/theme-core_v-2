<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Domains\Compositions;

use Rombt\ThemeCore\Resolution\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeComponents\ThemeIr;

final readonly class CompositionResolver implements ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
        ThemeIr $ir,
    ): ThemeIr {
        $id = new ComponentId('compositions');

        if (!$components->has($id)) {
            return $ir;
        }

        $component = $components
            ->get($id)
            ->component();

        if (!$component instanceof CompositionsComponent) {
            return $ir;
        }

        $compositions = [];

        foreach ($component->compositions()->compositions() as $id => $configuration) {
            $compositions[$id] = new Composition(
                id: $id,
                type: $configuration['type'] ?? 'template',
                children: $this->resolveChildren(
                    $configuration['children'] ?? [],
                ),
            );
        }

        $ir->set(
            'compositions',
            new CompositionIr(
                new CompositionCollection($compositions),
            ),
        );

        return $ir;
    }

    /**
     * @param array<int, mixed> $children
     * @return array<CompositionChild|string>
     */
    private function resolveChildren(array $children): array
    {
        $result = [];

        foreach ($children as $child) {
            if (is_string($child)) {
                $result[] = $child;

                continue;
            }

            $result[] = new CompositionChild(
                id: $child['id'] ?? 'composition',
                children: $this->resolveChildren(
                    $child['children'] ?? [],
                ),
            );
        }

        return $result;
    }
}
