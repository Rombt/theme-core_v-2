<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Runtime;

use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceComposerInterface;
use Rombt\ThemeCore\Theme\ThemeComponentBuilderRegistry;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageRegistryInterface;

final class CompositionRuntime implements CompositionRuntimeInterface
{
    public function __construct(
        private readonly ServiceComposerInterface $services,
        private readonly PackageRegistryInterface $packageRegistry,
        private readonly ThemeComponentBuilderRegistry $componentBuilderRegistry,
    ) {
    }

    public function services(): ServiceComposerInterface
    {
        return $this->services;
    }

    public function packageRegistry(): PackageRegistryInterface
    {
        return $this->packageRegistry;
    }

    public function componentBuilderRegistry(): ThemeComponentBuilderRegistry
    {
        return $this->componentBuilderRegistry;
    }
}
