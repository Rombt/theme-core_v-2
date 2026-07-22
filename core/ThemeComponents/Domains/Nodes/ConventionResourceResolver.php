<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Contracts\ResourceResolverInterface;

final class ConventionResourceResolver implements ResourceResolverInterface
{
    public function resolve(string $resource): ResolvedResource
    {
        return new ResolvedResource(
            exists: false,
            absolutePath: '',
            relativePath: '',
            type: ResourceType::unknown(),
        );
    }
}
