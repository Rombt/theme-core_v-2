<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Functions;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final readonly class FunctionDefinitionCollection implements IteratorAggregate, Countable
{
    /**
     * @var array<FunctionDefinition>
     */
    private array $functions;

    /**
     * @param iterable<FunctionDefinition> $functions
     */
    public function __construct(iterable $functions = [])
    {
        $this->functions = is_array($functions)
            ? $functions
            : iterator_to_array($functions);
    }

    /**
     * @return Traversable<int, FunctionDefinition>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->functions);
    }

    public function count(): int
    {
        return count($this->functions);
    }

    /**
     * @return array<FunctionDefinition>
     */
    public function all(): array
    {
        return $this->functions;
    }

    public function find(string $id): ?FunctionDefinition
    {
        foreach ($this->functions as $function) {
            if ($function->id() === $id) {
                return $function;
            }
        }

        return null;
    }
}
