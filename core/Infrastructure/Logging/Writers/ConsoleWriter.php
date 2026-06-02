<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging\Writers;

use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;

final class ConsoleWriter implements LogWriterInterface
{
    public function write(string $payload): void
    {
        echo $payload . PHP_EOL;
    }
}
