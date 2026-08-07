<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators\Templates;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;

interface TemplateRendererInterface
{
    public function render(
        Template $template,
    ): string;
}
