<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Renderers;

use Rombt\ThemeCore\Artifacts\Contracts\CompositionNodeRendererInterface;

final class SiteTitleNodeRenderer implements CompositionNodeRendererInterface
{
    public function supports(string $node): bool
    {
        return $node === 'site-title';
    }

    public function render(string $node): string
    {
        return <<<'HTML'
            <!-- wp:site-title /-->
            HTML;
    }
}
