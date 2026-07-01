<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Renderers;

use Rombt\ThemeCore\Artifacts\Contracts\CompositionNodeRendererInterface;

final class PostLoopNodeRenderer implements CompositionNodeRendererInterface
{
    public function supports(string $node): bool
    {
        return $node === 'post-loop';
    }

    public function render(string $node): string
    {
        return <<<'HTML'
            <!-- wp:query -->
            <div class="wp-block-query">
                <!-- wp:post-template -->
                    <!-- wp:post-title {"isLink":true} /-->
                    <!-- wp:post-excerpt /-->
                <!-- /wp:post-template -->
            </div>
            <!-- /wp:query -->
            HTML;
    }
}
