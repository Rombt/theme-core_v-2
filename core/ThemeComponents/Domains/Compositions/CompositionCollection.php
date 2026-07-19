<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class CompositionCollection implements IteratorAggregate
{
    /**
     * @param Composition[] $compositions
     */
    public function __construct(
        private array $compositions = [],
    ) {
    }

    public function add(
        Composition $composition,
    ): void {
        $this->compositions[] = $composition;
    }

    /**
     * @return Composition[]
     */
    public function all(): array
    {
        return $this->compositions;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->compositions);
    }
}
