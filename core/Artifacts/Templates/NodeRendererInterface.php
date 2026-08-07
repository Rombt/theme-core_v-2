<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators\Templates;

use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Node;

interface NodeRendererInterface
{
    public function supports(
        Node $node,
    ): bool;

    public function render(
        Node $node,
    ): string;
}
