<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Contracts;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ResolvedResource;

interface ResourceResolverInterface
{
    public function resolve(string $resource): ResolvedResource;
}
