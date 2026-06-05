<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface ServiceRegistrarInterface
{
    public function register(
        ServiceRegistryInterface $registry
    ): void;
}
