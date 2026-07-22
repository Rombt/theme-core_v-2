<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

final readonly class Node
{
    /**
     * @param array<string, mixed> $type
     * @param array<int, string> $capabilities
     * @param array<string, mixed> $metadata
     */
    public function __construct(
        private string $id,
        private array $type,
        private string $name,
        private ?string $description = null,
        private array $capabilities = [],
        private array $metadata = [],
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return array<string, mixed>
     */
    public function type(): array
    {
        return $this->type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    /**
     * @return array<int, string>
     */
    public function capabilities(): array
    {
        return $this->capabilities;
    }

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array
    {
        return $this->metadata;
    }
}
