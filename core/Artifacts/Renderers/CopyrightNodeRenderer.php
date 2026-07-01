<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Renderers;

use Rombt\ThemeCore\Artifacts\Contracts\CompositionNodeRendererInterface;

final class CopyrightNodeRenderer implements CompositionNodeRendererInterface
{
    public function supports(string $node): bool
    {
        return $node === 'copyright';
    }

    public function render(string $node): string
    {
        return <<<'HTML'
        <!-- wp:paragraph -->
        <p>© Copyright</p>
        <!-- /wp:paragraph -->
        HTML;
    }
}
