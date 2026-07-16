<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

final class ThemeIr
{
    /**
     * @var array<string, object>
     */
    private array $domains = [];

    public function has(string $id): bool
    {
        return isset($this->domains[$id]);
    }

    public function set(
        string $id,
        object $domain,
    ): void {
        $this->domains[$id] = $domain;
    }

    public function get(string $id): object
    {
        return $this->domains[$id];
    }

    /**
     * @return array<string, object>
     */
    public function all(): array
    {
        return $this->domains;
    }

    public function domain(
        string $id,
    ): ?object {
        return $this->domains[$id] ?? null;
    }
}
