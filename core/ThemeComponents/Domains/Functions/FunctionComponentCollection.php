<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Functions;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, FunctionComponent>
 */
final class FunctionComponentCollection implements IteratorAggregate, Countable
{
    /**
     * @param list<FunctionComponent> $functions
     */
    public function __construct(
        private readonly array $functions = [],
    ) {
    }

    /**
     * @return list<FunctionComponent>
     */
    public function all(): array
    {
        return $this->functions;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->functions);
    }

    public function count(): int
    {
        return count($this->functions);
    }
}
