<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateTreeMaterializerInterface;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateTreeRendererInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\Template;

final readonly class BlockTemplateTreeRenderer implements TemplateTreeRendererInterface
{
    public function __construct(
        private TemplateTreeMaterializerInterface $materializer,
    ) {
    }

    public function render(
        Template $template,
    ): string {
        return $this->materializer
            ->materialize($template)
            ->content();
    }
}
