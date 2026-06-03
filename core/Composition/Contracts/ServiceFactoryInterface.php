<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface ServiceFactoryInterface
{
    /**
     * @param array<int, object> $dependencies
     */
    public function create(
        string $class,
        array $dependencies = []
    ): object;
}
