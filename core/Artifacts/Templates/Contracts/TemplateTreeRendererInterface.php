<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates\Contracts;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;

interface TemplateTreeRendererInterface
{
    public function render(
        Template $template,
    ): string;
}
