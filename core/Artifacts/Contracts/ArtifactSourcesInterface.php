<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

interface ArtifactSourcesInterface
{
    /**
     * @param class-string $source
     */
    public function has(string $source): bool;

    /**
     * @param class-string $source
     */
    public function get(string $source): ?object;

    /**
     * @return array<class-string, object>
     */
    public function all(): array;
}
