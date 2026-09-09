<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use ArrayIterator;
use IteratorAggregate;
use RuntimeException;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeConceptInterface;
use Traversable;

/**
 * @implements IteratorAggregate<string, ThemeConceptInterface>
 */
final class ThemeIR implements IteratorAggregate
{
    /**
     * @var array<string, ThemeConceptInterface>
     */
    private array $concepts = [];

    public function add(ThemeConceptInterface $concept): void
    {
        $this->concepts[$concept->id()] = $concept;
    }

    public function has(string $id): bool
    {
        return isset($this->concepts[$id]);
    }

    public function get(string $id): ThemeConceptInterface
    {
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
     * @template T of ThemeConceptInterface
     *
     * @param class-string<T> $contract
     * @return T
     */
    public function concept(string $contract): ThemeConceptInterface
    {
        foreach ($this->concepts as $concept) {
            if ($concept instanceof $contract) {
                return $concept;
            }
        }

        throw new RuntimeException(
            sprintf(
                'Theme Concept implementing "%s" not found.',
                $contract,
            ),
        );
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
