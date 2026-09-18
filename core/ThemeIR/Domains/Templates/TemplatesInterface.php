<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Templates;

use Rombt\ThemeCore\ThemeIR\Contracts\ThemeConceptInterface;

interface TemplatesInterface extends ThemeConceptInterface
{
    public function templates(): TemplateCollection;
}
