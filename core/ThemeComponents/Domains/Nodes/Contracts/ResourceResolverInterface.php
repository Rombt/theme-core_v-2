<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Contracts;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Resource;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ResolvedResource;

interface ResourceResolverInterface
{
    public function resolve(Resource $resource): ResolvedResource;
}
