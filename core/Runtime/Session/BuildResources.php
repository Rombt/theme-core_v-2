<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

final class BuildResources
{
    /**
     * @var array<string, mixed>
     */
    private array $resources = [];

    public function set(string $key, mixed $resource): void
    {
        $this->resources[$key] = $resource;
    }

    public function get(string $key): mixed
    {
        return $this->resources[$key] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->resources;
    }
}
