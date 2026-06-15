<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application\Contracts;

interface ApplicationContextBuilderInterface
{
    public function register(
        string $key,
        object $value
    ): void;

    public function has(string $key): bool;

    public function get(string $key): object;

    public function build(): ApplicationContextInterface;

    public function isBuilt(): bool;
}
