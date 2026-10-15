<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging\Writers;

use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;

final class ConsoleWriter implements LogWriterInterface
{
    public function __construct(
        private readonly bool $toStderr = false,
    ) {
    }

    public function write(string $payload): void
    {
        fwrite(
            $this->toStderr && getenv('TEMPLIX_BUILD_PROTOCOL') === '1'
                ? STDERR
                : STDOUT,
            $payload . PHP_EOL,
        );
    }
}
