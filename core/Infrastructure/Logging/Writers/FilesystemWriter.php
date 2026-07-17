<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging\Writers;

use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;

final class FilesystemWriter implements LogWriterInterface
{
    private bool $initialized = false;

    public function __construct(
        private readonly string $path,
        private readonly bool $append = true,
    ) {
    }

    public function write(string $payload): void
    {
        $dir = dirname($this->path);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $flags = FILE_APPEND;

        if (!$this->append) {
            $flags = $this->initialized
                ? FILE_APPEND
                : 0;

            $this->initialized = true;
        }

        file_put_contents(
            $this->path,
            $payload . PHP_EOL,
            $flags,
        );
    }
}
