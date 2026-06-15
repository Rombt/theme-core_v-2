<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application\Contracts;

interface ApplicationContextInterface
{
    public function has(string $key): bool;

    public function get(string $key): object;

    /**
     * @return array<string, object>
     */
    public function all(): array;
}
