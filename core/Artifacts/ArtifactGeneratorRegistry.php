<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;

final readonly class ArtifactGeneratorRegistry
{
    /**
     * @param iterable<ArtifactGeneratorInterface> $generators
     */
    public function __construct(private iterable $generators)
    {
    }

    /**
     * @return iterable<ArtifactGeneratorInterface>
     */
    public function all(): iterable
    {
        return $this->generators;
    }
}
