<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Contracts;

interface ThemeComponentCollectionInterface
{
    public function get(string $id): ThemeComponentInterface;

    public function has(string $id): bool;
}
