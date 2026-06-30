<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;

final class ArtifactGeneratorRegistryFactory
{
    /**
     * @param iterable<ArtifactGeneratorInterface> $generators
     */
    public function create(iterable $generators): ArtifactGeneratorRegistry
    {
        return new ArtifactGeneratorRegistry(
            $generators
        );
    }
}
