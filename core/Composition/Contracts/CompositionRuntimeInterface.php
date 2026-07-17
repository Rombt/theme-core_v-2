<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageRegistryInterface;

interface CompositionRuntimeInterface
{
    public function services(): ServiceComposerInterface;

    public function packageRegistry(): PackageRegistryInterface;
}
