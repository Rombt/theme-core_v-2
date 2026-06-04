<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface DependencyResolverInterface
{
    /**
     * @return string[]
     */
    public function resolve(string $identifier): array;
}
