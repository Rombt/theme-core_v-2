<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators\Templates;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateNode;

interface TemplateNodeRendererInterface
{
    public function render(
        TemplateNode $node,
    ): string;
}
