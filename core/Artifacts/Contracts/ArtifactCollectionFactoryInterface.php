<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

interface ArtifactCollectionFactoryInterface
{
    public function create(): ArtifactCollectionInterface;
}
