<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Concepts\Templates;

use Rombt\ThemeCore\ThemeIr\Contracts\ThemeConceptInterface;

interface TemplatesInterface extends ThemeConceptInterface
{
    public function templates(): TemplateCollection;
}
