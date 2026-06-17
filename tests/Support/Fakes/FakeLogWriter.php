<?php

declare(strict_types=1);

namespace Tests\Support\Fakes;

use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;

final class FakeLogWriter implements LogWriterInterface
{
    /**
     * @var string[]
     */
    private array $payloads = [];

    public function write(
        string $payload
    ): void {
        $this->payloads[] = $payload;
    }

    /**
     * @return string[]
     */
    public function payloads(): array
    {
        return $this->payloads;
    }

    public function count(): int
    {
        return count($this->payloads);
    }
}
