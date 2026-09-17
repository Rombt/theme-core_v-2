<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

final readonly class Asset
{
    /**
     * @param array<int, string> $dependencies
     * @param array<string, mixed> $configuration
     */
    public function __construct(
        private string $id,
        private string $name,
        private AssetType $type,
        private Resource $resource,
        private string $destPath,
        private array $dependencies = [],
        private array $configuration = [],
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): AssetType
    {
        return $this->type;
    }

    public function resource(): Resource
    {
        return $this->resource;
    }

    public function destPath(): string
    {
        return $this->destPath;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return array<int, string>
     */
    public function dependencies(): array
    {
        return $this->dependencies;
    }

    /**
     * @return array<string, mixed>
     */
    public function configuration(): array
    {
        return $this->configuration;
    }
}
