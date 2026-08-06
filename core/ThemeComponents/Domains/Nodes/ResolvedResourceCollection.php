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
     * @var ResolvedResource[]
     */
    private array $resources;

    public function __construct(
        array $resources = [],
    ) {
        $this->resources = $resources;
    }

    /**
     * @return Traversable<int, ResolvedResource>
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
     * @return ResolvedResource[]
     */
    public function all(): array
    {
        return $this->resources;
    }
}
