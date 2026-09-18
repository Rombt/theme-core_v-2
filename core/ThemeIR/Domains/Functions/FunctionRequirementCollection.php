<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Functions;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, FunctionRequirement>
 */
final readonly class FunctionRequirementCollection implements IteratorAggregate, Countable
{
    /**
     * @param list<FunctionRequirement> $requirements
     */
    public function __construct(
        private array $requirements = [],
    ) {
    }

    /**
     * @return list<FunctionRequirement>
     */
    public function all(): array
    {
        return $this->requirements;
    }

    /**
     * @return Traversable<int, FunctionRequirement>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->requirements);
    }

    public function count(): int
    {
        return count($this->requirements);
    }
}
