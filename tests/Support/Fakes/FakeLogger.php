<?php

declare(strict_types=1);

namespace Tests\Support\Fakes;

use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticEntry;

final class FakeLogger implements LoggerInterface
{
    /**
     * @var DiagnosticEntry[]
     */
    private array $entries = [];

    public function write(
        DiagnosticEntry $entry
    ): void {
        $this->entries[] = $entry;
    }

    public function dump(
        mixed $value,
    ): void {
        // Intentionally empty: this fake logger does not output debug values.
    }

    /**
     * @return DiagnosticEntry[]
     */
    public function entries(): array
    {
        return $this->entries;
    }

    public function count(): int
    {
        return count($this->entries);
    }
}
