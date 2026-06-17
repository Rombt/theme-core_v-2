<?php

declare(strict_types=1);

namespace Tests\Integration\Composition;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Composition\Graph\DependencyGraph;
use Rombt\ThemeCore\Composition\Graph\DependencyNode;
use Rombt\ThemeCore\Composition\Graph\TopologicalSorter;

final class TopologicalSorterTest extends TestCase
{
    public function testTopologicalSortReturnsCorrectOrder(): void
    {
        $graph = new DependencyGraph([
        'A' => new DependencyNode('A', ['B', 'C']),
        'B' => new DependencyNode('B', ['D']),
        'C' => new DependencyNode('C', []),
        'D' => new DependencyNode('D', []),
        ]);

        $sorter = new TopologicalSorter();

        $result = $sorter->sort($graph);

        // D должен быть первым (глубочайшая зависимость)
        self::assertContains('D', $result);

        // B зависит от D → D должен идти раньше B
        self::assertTrue(
            array_search('D', $result, true) < array_search('B', $result, true)
        );

        // C не зависит → может быть раньше A
        self::assertContains('C', $result);

        // A всегда после своих зависимостей
        self::assertTrue(
            array_search('B', $result, true) < array_search('A', $result, true)
        );
    }
    public function testCircularDependencyThrowsException(): void
    {
        $this->expectException(
            \Rombt\ThemeCore\Composition\Exceptions\CompositionCycleException::class
        );

        $graph = new DependencyGraph([
            'A' => new DependencyNode('A', ['B']),
            'B' => new DependencyNode('B', ['C']),
            'C' => new DependencyNode('C', ['A']), // цикл
        ]);

        $sorter = new TopologicalSorter();

        $sorter->sort($graph);
    }
}
