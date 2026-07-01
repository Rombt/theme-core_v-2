<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Contracts;

interface CompositionNodeRendererInterface
{
    public function supports(string $node): bool;

    public function render(string $node): string;
}
