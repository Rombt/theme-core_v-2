<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Contracts\ResourceResolverInterface;

final readonly class ConventionResourceResolver implements ResourceResolverInterface
{
    public function resolve(Resource $resource): ResolvedResource
    {
        return new ResolvedResource(
            resource: $resource,
            exists: false,
            absolutePath: '',
            relativePath: '',
        );
    }
}
