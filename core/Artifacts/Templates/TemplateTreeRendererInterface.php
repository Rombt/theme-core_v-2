<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateTree;

interface TemplateTreeRendererInterface
{
    public function render(TemplateTree $tree): string;
}
