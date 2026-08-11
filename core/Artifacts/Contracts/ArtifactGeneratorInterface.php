<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;

interface ArtifactGeneratorInterface
{
    /**
     * @return class-string
     */
    public function supports(): string;

    public function generate(
        object $concept,
        ArtifactCollectionInterface $artifacts,
    ): void;
}
