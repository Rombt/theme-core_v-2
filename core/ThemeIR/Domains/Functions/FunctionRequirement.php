<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Functions;

final readonly class FunctionRequirement
{
    public function __construct(
        private Resource $resource,
        private int $order,
    ) {
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
