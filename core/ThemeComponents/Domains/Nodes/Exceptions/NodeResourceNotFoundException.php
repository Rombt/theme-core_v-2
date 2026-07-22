<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Exceptions;

use RuntimeException;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Resource;

final class NodeResourceNotFoundException extends RuntimeException
{
    public static function forResource(Resource $resource, string $path): self
    {
        return new self(sprintf(
            'Node resource "%s/%s" not found: %s',
            $resource->type(),
            $resource->id(),
            $path,
        ));
    }
}
