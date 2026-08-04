<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr;

use ArrayIterator;
use IteratorAggregate;
use Traversable;
use RuntimeException;
use Rombt\ThemeCore\ThemeIr\Contracts\ThemeConceptInterface;

final class ThemeIr implements IteratorAggregate
{
    /**
     * @var array<string, ThemeConceptInterface>
     */
    private array $concepts = [];

    public function add(
        ThemeConceptInterface $concept,
    ): void {
        $this->concepts[$concept->id()] = $concept;
    }

    public function has(
        string $id,
    ): bool {
        return isset($this->concepts[$id]);
    }

    public function get(
        string $id,
    ): ThemeConceptInterface {
        if (!$this->has($id)) {
            throw new RuntimeException(
                sprintf(
                    'Theme Concept "%s" not found.',
                    $id,
                ),
            );
        }

        return $this->concepts[$id];
    }

    /**
     * @return array<string, ThemeConceptInterface>
     */
    public function all(): array
    {
        return $this->concepts;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->concepts);
    }
}
