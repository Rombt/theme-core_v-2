<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface EagerServiceResolverInterface
{
    public function resolve(): void;
}
