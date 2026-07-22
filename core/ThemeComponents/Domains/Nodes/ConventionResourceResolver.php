<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Contracts\ResourceResolverInterface;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Exceptions\NodeResourceNotFoundException;

final readonly class ConventionResourceResolver implements ResourceResolverInterface
{
    public function __construct(
        private string $resourcePackage = '',
    ) {
    }

    public function resolve(Resource $resource): ResolvedResource
    {
        $relativePath = sprintf(
            '%s/%s',
            $resource->type(),
            $resource->id(),
        );

        $absolutePath = rtrim($this->resourcePackage, '/\\')
            . DIRECTORY_SEPARATOR
            . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

        if (!is_dir($absolutePath)) {
            throw NodeResourceNotFoundException::forResource(
                $resource,
                $absolutePath,
            );
        }

        return new ResolvedResource(
            resource: $resource,
            exists: true,
            absolutePath: $absolutePath,
            relativePath: $relativePath,
        );
    }
}
