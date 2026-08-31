<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Functions;

use Rombt\ThemeCore\ThemeIR\Concepts\Functions\ValueObjects\FunctionType;

final readonly class FunctionDeclaration
{
    public function __construct(
        private string $id,
        private FunctionType $type,
        private ?Resource $resource,
        private string $name,
        private ?string $description,
        private array $configuration = [],
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): FunctionType
    {
        return $this->type;
    }

    public function resource(): ?Resource
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

    public function configuration(): array
    {
        return $this->configuration;
    }
}
