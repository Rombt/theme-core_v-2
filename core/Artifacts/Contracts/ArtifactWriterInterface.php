<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

interface ArtifactWriterInterface
{
    public function write(
        ArtifactCollectionInterface $artifacts
    ): void;
}
