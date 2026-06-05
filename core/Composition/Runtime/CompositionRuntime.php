<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Runtime;

use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceComposerInterface;

final class CompositionRuntime implements CompositionRuntimeInterface
{
    public function __construct(
        private readonly ServiceComposerInterface $services
    ) {
    }

    public function services(): ServiceComposerInterface
    {
        return $this->services;
    }
}
