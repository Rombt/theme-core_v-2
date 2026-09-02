<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Functions;

use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeConcept;

final readonly class Functions extends ThemeConcept implements FunctionsInterface
{
    public function __construct(
        IrId $id,
        private FunctionDeclarationCollection $declarations,
        private FunctionRequirementCollection $requirements,
    ) {
        parent::__construct($id);
    }

    public function declarations(): FunctionDeclarationCollection
    {
        return $this->declarations;
    }

    public function requirements(): FunctionRequirementCollection
    {
        return $this->requirements;
    }
}
