<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging\Writers;

use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;

final class CompositeWriter implements LogWriterInterface
{
    /**
     * @param LogWriterInterface[] $writers
     */
    public function __construct(
        private readonly array $writers
    ) {
    }

    public function write(string $payload): void
    {
        foreach ($this->writers as $writer) {
            $writer->write($payload);
        }
    }
}
