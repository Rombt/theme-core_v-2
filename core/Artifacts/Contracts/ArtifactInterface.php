<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;

interface ArtifactInterface
{
    public function id(): ArtifactId;

    public function type(): ArtifactType;

    public function destination(): string;

    public function content(): string;

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array;
}
