<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Countable;
use IteratorAggregate;
use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;

/**
 * @extends IteratorAggregate<int, Artifact>
 */
interface ArtifactCollectionInterface extends Countable, IteratorAggregate
{
    public function add(Artifact $artifact): void;

    public function replace(Artifact $artifact): void;

    public function remove(ArtifactId $id): void;

    public function get(ArtifactId $id): ?Artifact;

    public function has(ArtifactId $id): bool;

    /**
     * @return array<Artifact>
     */
    public function all(): array;
}
