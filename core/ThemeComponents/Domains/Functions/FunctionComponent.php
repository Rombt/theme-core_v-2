<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Functions;

final readonly class FunctionComponent
{
    public function __construct(
        private string $id,
        private string $type,
        private ?string $resource,
        private string $name,
        private ?string $description,
        private array $configuration = [],
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

    public function configuration(): array
    {
        return $this->configuration;
    }
}
