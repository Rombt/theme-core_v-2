<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrInterface;

interface ArtifactGeneratorInterface
{
    /**
     * @return class-string<ThemeIrInterface>
     */
    public function supports(): string;

    public function generate(
        ThemeIrInterface $ir,
        ArtifactCollectionInterface $artifacts,
    ): void;
}
