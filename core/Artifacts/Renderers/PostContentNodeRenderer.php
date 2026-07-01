<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Renderers;

use Rombt\ThemeCore\Artifacts\Contracts\CompositionNodeRendererInterface;

final class PostContentNodeRenderer implements CompositionNodeRendererInterface
{
    public function supports(string $node): bool
    {
        return $node === 'post-content';
    }

    public function render(string $node): string
    {
        return <<<'HTML'
        <!-- wp:post-content /-->
        HTML;
    }
}
