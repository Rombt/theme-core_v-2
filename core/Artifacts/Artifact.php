<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactInterface;

final readonly class Artifact implements ArtifactInterface
{
    /**
     * @param array<string, mixed> $metadata
     */
    public function __construct(
        private ArtifactId $id,
        private ArtifactType $type,
        private string $destination,
        private string $content,
        private array $metadata = []
    ) {
    }

    public function id(): ArtifactId
    {
        return $this->id;
    }

    public function type(): ArtifactType
    {
        return $this->type;
    }

    public function destination(): string
    {
        return $this->destination;
    }

    public function content(): string
    {
        return $this->content;
    }

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array
    {
        return $this->metadata;
    }
}
