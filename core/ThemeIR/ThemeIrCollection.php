<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrInterface;
use Traversable;

final readonly class ThemeIrCollection implements IteratorAggregate, Countable
{
    /**
     * @param ThemeIrInterface[] $items
     */
    public function __construct(
        private array $items,
    ) {
    }

    /**
     * @return Traversable<ThemeIrInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @return ThemeIrInterface[]
     */
    public function all(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }
}
