<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Definitions\FunctionDefinition;

final readonly class Node
{
    /**
     * @param array<int, string> $capabilities
     * @param array<string, mixed> $metadata
     */
    public function __construct(
        private string $id,
        private NodeType $type,
        private ?string $resource,
        private string $name,
        private ?string $strategy = null,
        private ?string $description = null,
        private array $capabilities = [],
        private array $metadata = [],
        private ?string $rendering = null,
        private ?FunctionDefinition $function = null,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): NodeType
    {
        return $this->type;
    }

    public function resource(): ?string
    {
        return $this->resource;
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

    public function strategy(): ?string
    {
        return $this->strategy;
    }

    public function hasStrategyOverride(): bool
    {
        return $this->strategy !== null;
    }

    public function rendering(): ?string
    {
        return $this->rendering;
    }

    public function function(): ?FunctionDefinition
    {
        return $this->function;
    }

    public function hasFunction(): bool
    {
        return $this->function !== null;
    }
}
