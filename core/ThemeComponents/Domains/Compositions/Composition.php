<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use Rombt\ThemeCore\ThemeComponents\Domains\Rendering\Rendering;

final class Composition
{
    private CompositionNodeCollection $defaultChildren;
    private bool $resourceSkipped = false;


    public function __construct(
        private readonly string $id,
        private readonly CompositionType $type,
        private ?string $resource,
        private readonly ?Rendering $rendering,
    ) {
        $this->defaultChildren = new CompositionNodeCollection();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function resource(): ?string
    {
        return $this->resource;
    }

    public function resourceSkipped(): bool
    {
        return $this->resourceSkipped;
    }

    public function markResourceSkipped(): void
    {
        $this->resource = null;
        $this->resourceSkipped = true;
    }

    public function rendering(): ?Rendering
    {
        return $this->rendering;
    }

    public function defaultChildren(): CompositionNodeCollection
    {
        return $this->defaultChildren;
    }

    public function setDefaultChildren(
        CompositionNodeCollection $defaultChildren,
    ): void {
        $this->defaultChildren = $defaultChildren;
    }

    public function type(): CompositionType
    {
        return $this->type;
    }
}
