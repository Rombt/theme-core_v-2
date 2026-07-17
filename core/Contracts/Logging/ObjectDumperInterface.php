<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Contracts\Logging;

interface ObjectDumperInterface
{
    public function dump(
        mixed $value,
    ): string;
}
