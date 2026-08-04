<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Domains\Templates;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final readonly class TemplateCollection implements IteratorAggregate, Countable
{
    /**
     * @var array<Template>
     */
    private array $templates;

    /**
     * @param iterable<Template> $templates
     */
    public function __construct(
        iterable $templates = [],
    ) {
        $this->templates = is_array($templates)
            ? $templates
            : iterator_to_array($templates);
    }

    /**
     * @return array<Template>
     */
    public function all(): array
    {
        return $this->templates;
    }

    /**
     * @return Traversable<Template>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->templates);
    }

    public function count(): int
    {
        return count($this->templates);
    }
}
