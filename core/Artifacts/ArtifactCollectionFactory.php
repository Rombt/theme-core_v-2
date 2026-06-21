<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionFactoryInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;

final class ArtifactCollectionFactory implements ArtifactCollectionFactoryInterface
{
    public function create(): ArtifactCollectionInterface
    {
        return new ArtifactCollection();
    }
}
