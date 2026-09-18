<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeIR\Domains\Functions\Resource;

final readonly class FunctionDefinition
{
    public function __construct(
        private bool $enabled,
        private Resource $resource,
        private int $order,
    ) {
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function resource(): Resource
    {
        return $this->resource;
    }

    public function order(): int
    {
        return $this->order;
    }
}
