<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

interface ArtifactGeneratorInterface
{
    /**
     * Returns the class-string of the data source
     * required by this generator.
     *
     * @return class-string
     */
    public function source(): string;

    public function generate(
        object $source,
        ArtifactCollectionInterface $artifacts,
    ): void;
}
