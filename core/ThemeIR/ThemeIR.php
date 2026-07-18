<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrInterface;

abstract readonly class ThemeIr implements ThemeIrInterface
{
    public function __construct(
        private IrId $id,
    ) {
    }

    public function id(): IrId
    {
        return $this->id;
    }
}
