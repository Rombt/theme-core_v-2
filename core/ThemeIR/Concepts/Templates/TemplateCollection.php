<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Templates;

use Countable;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

/**
 * @implements IteratorAggregate<int, Template>
 */
final class TemplateCollection implements IteratorAggregate, Countable
{
    /**
     * @param array<int, Template> $templates
     */
    public function __construct(
        private readonly array $templates = [],
    ) {
    }

    /**
     * @return array<int, Template>
     */
    public function all(): array
    {
        return $this->templates;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->templates);
    }

    public function count(): int
    {
        return count($this->templates);
    }
}
