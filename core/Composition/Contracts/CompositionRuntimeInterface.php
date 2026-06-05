<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface CompositionRuntimeInterface
{
    public function services(): ServiceComposerInterface;
}
