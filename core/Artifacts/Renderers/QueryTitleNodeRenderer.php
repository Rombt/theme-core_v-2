<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Renderers;

use Rombt\ThemeCore\Artifacts\Contracts\CompositionNodeRendererInterface;

final class QueryTitleNodeRenderer implements CompositionNodeRendererInterface
{
    public function supports(string $node): bool
    {
        return in_array($node, [
            'page-title',
            'archive-title',
        ], true);
    }

    public function render(string $node): string
    {
        return <<<'HTML'
            <!-- wp:query-title /-->
        HTML;
    }
}
