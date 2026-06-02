<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Contracts\Logging;

interface LogWriterInterface
{
    public function write(
        string $payload
    ): void;
}
