<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\WordPress\Assets;

final readonly class AssetRegistration
{
    /**
     * @param array<int, string> $dependencies
     */
    public function __construct(
        private string $handle,
        private string $type,
        private string $source,
        private array $dependencies = [],
    ) {
    }

    public function handle(): string
    {
        return $this->handle;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function source(): string
    {
        return $this->source;
    }

    /**
     * @return array<int, string>
     */
    public function dependencies(): array
    {
        return $this->dependencies;
    }
}
