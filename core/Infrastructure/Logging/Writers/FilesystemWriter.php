<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging\Writers;

use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;
use Rombt\ThemeCore\Configuration\Configuration;

final class FilesystemWriter implements LogWriterInterface
{
    private string $path;

    public function __construct(Configuration $config)
    {
        $this->path = $config->get('logging.path');
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
