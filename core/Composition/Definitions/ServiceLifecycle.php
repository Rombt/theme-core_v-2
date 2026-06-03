<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Definitions;

final class ServiceLifecycle
{
    public const EAGER = 'eager';

    public const LAZY = 'lazy';

    public const TRANSIENT = 'transient';

    private function __construct()
    {
    }
}
