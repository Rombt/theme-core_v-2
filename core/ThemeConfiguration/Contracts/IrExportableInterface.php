<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

interface IrExportableInterface
{
    public function toArray(): array;
}
