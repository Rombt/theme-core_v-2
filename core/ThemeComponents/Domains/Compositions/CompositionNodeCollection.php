<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class CompositionNodeCollection implements IteratorAggregate
{
    /**
     * @param CompositionNode[] $nodes
     */
    public function __construct(
        private array $nodes = [],
    ) {
    }

    public function add(
        CompositionNode $node,
    ): void {
        $this->nodes[] = $node;
    }

    /**
     * @return CompositionNode[]
     */
    public function all(): array
    {
        return $this->nodes;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->nodes);
    }
}
