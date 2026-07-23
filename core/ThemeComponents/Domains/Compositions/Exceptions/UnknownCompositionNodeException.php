<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions\Exceptions;

use RuntimeException;

final class UnknownCompositionNodeException extends RuntimeException
{
    public static function forId(
        string $id,
    ): self {
        return new self(
            sprintf(
                'Composition references unknown node "%s".',
                $id,
            ),
        );
    }
}
