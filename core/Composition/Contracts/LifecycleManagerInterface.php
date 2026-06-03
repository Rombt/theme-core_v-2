<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface LifecycleManagerInterface
{
    public function shouldStore(string $lifecycle): bool;
}
