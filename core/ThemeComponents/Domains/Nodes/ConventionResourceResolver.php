<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Contracts\ResourceResolverInterface;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Exceptions\NodeResourceNotFoundException;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ValueObjects\ResourceArchitecture;

final readonly class ConventionResourceResolver implements ResourceResolverInterface
{
    public function __construct(
        private string $resourcePackage = '',
    ) {
    }

    public function resolve(
        Resource $resource,
    ): ResolvedResourceCollection {
        $architectures = [];

        foreach (ResourceArchitecture::cases() as $architecture) {
            $relativePath = sprintf(
                'components/%s/%s.%s.%s',
                $resource->id(),
                $resource->type(),
                $architecture->value,
                $this->extension($architecture),
            );

            $absolutePath = rtrim($this->resourcePackage, '/\\')
                . DIRECTORY_SEPARATOR
                . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

            if (!is_file($absolutePath)) {
                continue;
            }

            $architectures[$architecture->value] = new ResolvedResourceArchitecture(
                architecture: $architecture,
                exists: true,
                absolutePath: $absolutePath,
                relativePath: $relativePath,
            );
        }

        if ($architectures === []) {
            throw NodeResourceNotFoundException::forResource(
                $resource,
                rtrim($this->resourcePackage, '/\\')
                . DIRECTORY_SEPARATOR
                . 'components'
                . DIRECTORY_SEPARATOR
                . $resource->id(),
            );
        }

        return new ResolvedResourceCollection([
            new ResolvedResource(
                resource: $resource,
                architectures: $architectures,
            ),
        ]);
    }

    private function extension(
        ResourceArchitecture $architecture,
    ): string {
        return match ($architecture) {
            ResourceArchitecture::Classic => 'php',
            ResourceArchitecture::Block => 'html',
        };
    }
}
