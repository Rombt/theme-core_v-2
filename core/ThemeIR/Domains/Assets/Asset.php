<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use Rombt\ThemeCore\ThemeIR\Domains\Assets\ValueObjects\AssetType;
use Rombt\ThemeCore\ThemeIR\FunctionDefinition;

final readonly class Asset
{
    /**
     * @param list<string> $dependencies
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
        private ?FunctionDefinition $function = null,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
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

    /**
     * @return list<string>
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

    public function function(): ?FunctionDefinition
    {
        return $this->function;
    }
}
