<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Countable;
use IteratorAggregate;
use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;

interface ArtifactCollectionInterface extends
    ArtifactRepositoryInterface,
    Countable,
    IteratorAggregate
{
    /**
     * @return array<Artifact>
     */
    public function all(): array;
}
