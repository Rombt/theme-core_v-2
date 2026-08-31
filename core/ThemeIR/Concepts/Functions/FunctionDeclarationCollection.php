<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Functions;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, FunctionDeclaration>
 */
final class FunctionDeclarationCollection implements IteratorAggregate, Countable
{
    /**
     * @param list<FunctionDeclaration> $declarations
     */
    public function __construct(
        private readonly array $declarations = [],
    ) {
    }

    /**
     * @return list<FunctionDeclaration>
     */
    public function all(): array
    {
        return $this->declarations;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->declarations);
    }

    public function count(): int
    {
        return count($this->declarations);
    }
}
