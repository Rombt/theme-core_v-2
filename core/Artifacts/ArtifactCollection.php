<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;

final class ArtifactCollection implements
    ArtifactCollectionInterface,
    Countable,
    IteratorAggregate
{
    /**
     * @var array<string, Artifact>
     */
    private array $artifacts = [];

    public function add(Artifact $artifact): void
    {
        $this->artifacts[(string) $artifact->id()] = $artifact;
    }

    public function replace(Artifact $artifact): void
    {
        $this->artifacts[(string) $artifact->id()] = $artifact;
    }

    public function remove(ArtifactId $id): void
    {
        unset($this->artifacts[(string) $id]);
    }

    public function get(ArtifactId $id): ?Artifact
    {
        return $this->artifacts[(string) $id] ?? null;
    }

    public function has(ArtifactId $id): bool
    {
        return isset($this->artifacts[(string) $id]);
    }

    /**
     * @return array<Artifact>
     */
    public function all(): array
    {
        return array_values($this->artifacts);
    }

    public function count(): int
    {
        return count($this->artifacts);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator(
            $this->all()
        );
    }
}
