<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;

interface ArtifactRepositoryInterface
{
    public function add(Artifact $artifact): void;

    public function replace(Artifact $artifact): void;

    public function remove(ArtifactId $id): void;

    public function get(ArtifactId $id): ?Artifact;

    public function has(ArtifactId $id): bool;
}
