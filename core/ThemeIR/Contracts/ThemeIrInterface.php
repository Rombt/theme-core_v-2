<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Contracts;

use Rombt\ThemeCore\ThemeIR\IrId;

interface ThemeIrInterface
{
    public function id(): IrId;
}
