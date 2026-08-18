<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final class NodeCollection implements IteratorAggregate, Countable
{
    /**
     * @param Node[] $nodes
     */
    public function __construct(
        private array $nodes = [],
    ) {
    }

    public function add(Node $node): void
    {
        $this->nodes[] = $node;
    }

    public function find(string $id): ?Node
    {
        foreach ($this->nodes as $node) {
            if ($node->id() === $id) {
                return $node;
            }
        }

        return null;
    }

    /**
     * @return Node[]
     */
    public function all(): array
    {
        return $this->nodes;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->nodes);
    }

    public function count(): int
    {
        return count($this->nodes);
    }

    public function isEmpty(): bool
    {
        return $this->nodes === [];
    }
}
