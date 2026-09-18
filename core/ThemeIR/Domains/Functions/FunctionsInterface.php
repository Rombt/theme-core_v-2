<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Functions;

use Rombt\ThemeCore\ThemeIR\Contracts\ThemeConceptInterface;

interface FunctionsInterface extends ThemeConceptInterface
{
    public function declarations(): FunctionDeclarationCollection;

    public function requirements(): FunctionRequirementCollection;
}
