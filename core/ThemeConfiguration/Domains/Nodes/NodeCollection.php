<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final readonly class NodeCollection implements IteratorAggregate, Countable
{
    /**
     * @var array<Node>
     */
    private array $nodes;

    /**
     * @param iterable<Node> $nodes
     */
    public function __construct(iterable $nodes = [])
    {
        $this->nodes = is_array($nodes)
            ? $nodes
            : iterator_to_array($nodes);
    }

    /**
     * @return Traversable<Node>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->nodes);
    }

    public function count(): int
    {
        return count($this->nodes);
    }

    /**
     * @return array<Node>
     */
    public function all(): array
    {
        return $this->nodes;
    }

    public function find(
        string $id,
    ): ?Node {
        foreach ($this->nodes as $node) {
            if ($node->id() === $id) {
                return $node;
            }
        }

        return null;
    }
}
