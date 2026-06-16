<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging\Writers;

use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;
use Rombt\ThemeCore\Configuration\Configuration;

final class FilesystemWriter implements LogWriterInterface
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function write(string $payload): void
    {
        $dir = dirname($this->path);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents(
            $this->path,
            $payload . PHP_EOL,
            FILE_APPEND
        );
    }
}
