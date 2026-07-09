<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\PackageId;

interface ThemePackageInterface
{
    public function id(): PackageId;

    public function path(): string;

    /**
     * @return array<string, mixed>
     */
    public function configuration(): array;
}
