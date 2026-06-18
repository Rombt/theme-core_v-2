<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration\Contracts;

interface ConfigurationInterface
{
    /**
     * @return mixed
     */
    public function get(string $key): mixed;

    /**
     * @return array<string, mixed>
     */
    public function all(): array;
}
