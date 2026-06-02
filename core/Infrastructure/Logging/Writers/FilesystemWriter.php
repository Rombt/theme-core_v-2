<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging\Writers;

use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;

final class FilesystemWriter implements LogWriterInterface
{
    public function __construct(private readonly string $path,)
    {
    }

    public function write(string $payload): void
    {

        file_put_contents(
            $this->path,
            $payload . PHP_EOL,
            FILE_APPEND
        );
    }
}
