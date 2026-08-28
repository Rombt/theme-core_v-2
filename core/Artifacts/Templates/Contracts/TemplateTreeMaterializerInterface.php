<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates\Contracts;

use Rombt\ThemeCore\Artifacts\Templates\TemplateMaterializationResult;
use Rombt\ThemeCore\ThemeIR\Concepts\Templates\Template;

interface TemplateTreeMaterializerInterface
{
    public function materialize(
        Template $template,
    ): TemplateMaterializationResult;
}
