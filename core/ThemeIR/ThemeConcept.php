<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeIR\Contracts\ThemeConceptInterface;

abstract readonly class ThemeConcept implements ThemeConceptInterface
{
    public function __construct(private IrId $id)
    {
    }

    public function id(): string
    {
        return $this->id->value();
    }

    /**
     * @return list<\Rombt\ThemeCore\ThemeIR\Contracts\FunctionComponentInterface>
     */
    public function functionComponents(): array
    {
        return [];
    }
}
