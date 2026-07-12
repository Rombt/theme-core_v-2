<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

final readonly class Asset
{
    /**
     * @param array<int, string> $dependencies
     */
    public function __construct(
        private string $id,
        private string $type,
        private string $entry,
        private array $dependencies = [],
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function entry(): string
    {
        return $this->entry;
    }

    /**
     * @return array<int, string>
     */
    public function dependencies(): array
    {
        return $this->dependencies;
    }
}
