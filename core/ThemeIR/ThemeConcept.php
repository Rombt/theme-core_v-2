<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr;

use Rombt\ThemeCore\ThemeIr\Contracts\ThemeConceptInterface;

abstract readonly class ThemeConcept implements ThemeConceptInterface
{
    public function __construct(
        private IrId $id,
    ) {
    }

    public function id(): string
    {
        return $this->id->value();
    }
}
