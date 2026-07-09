<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

final readonly class ThemePackageRegistration
{
    public function __construct(
        private PackageId $id,
        private PackageMetadata $metadata,
        private array $configuration,
        private string $path,
    ) {
    }

    public function id(): PackageId
    {
        return $this->id;
    }

    public function metadata(): PackageMetadata
    {
        return $this->metadata;
    }

    public function configuration(): array
    {
        return $this->configuration;
    }

    public function path(): string
    {
        return $this->path;
    }
}
