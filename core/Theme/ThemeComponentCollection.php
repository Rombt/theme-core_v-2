<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class ThemeComponentCollection implements IteratorAggregate
{
    /**
     * @param ThemeComponent[] $components
     */
    public function __construct(
        private array $components = [],
    ) {
    }

    public function add(ThemeComponent $component): void
    {
        $this->components[] = $component;
    }

    /**
     * @return ThemeComponent[]
     */
    public function all(): array
    {
        return $this->components;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->components);
    }
}
