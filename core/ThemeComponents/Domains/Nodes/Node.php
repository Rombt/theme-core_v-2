<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\Domains\Rendering\Rendering;
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
        private ?NodeStrategy $strategy = null,
        private ?string $description = null,
        private array $capabilities = [],
        private array $metadata = [],
        private ?FunctionDefinition $function = null,
        private ?Rendering $rendering = null,
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

    public function strategy(): ?NodeStrategy
    {
        return $this->strategy;
    }

    public function hasStrategyOverride(): bool
    {
        return $this->strategy !== null;
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

    public function function(): ?bool
    {
        return $this->function;
    }

    public function rendering(): ?Rendering
    {
        return $this->rendering;
    }
}
