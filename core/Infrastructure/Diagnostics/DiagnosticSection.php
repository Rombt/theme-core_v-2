<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Diagnostics;

final class DiagnosticSection
{
    /**
     * @var array<string, mixed>
     */
    private array $data = [];

    public function set(
        string $key,
        mixed $value
    ): self {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->data;
    }
}
