<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final readonly class ResolvedResourceCollection implements IteratorAggregate, Countable
{
    /**
     * @var array<ResolvedResource>
     */
    private array $resources;

    /**
     * @param iterable<ResolvedResource> $resources
     */
    public function __construct(iterable $resources = [])
    {
        $this->resources = is_array($resources)
            ? $resources
            : iterator_to_array($resources);
    }

    /**
     * @return Traversable<ResolvedResource>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->resources);
    }

    public function count(): int
    {
        return count($this->resources);
    }

    /**
     * @return array<ResolvedResource>
     */
    public function all(): array
    {
        return $this->resources;
    }
}
