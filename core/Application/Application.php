<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application;

final class Application
{
    /**
     * @var array<string, mixed>
     */
    private array $state = [];

    public function set(string $key, mixed $value): void
    {
        $this->state[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $this->state[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->state);
    }
}
