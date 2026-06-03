<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Lifecycle;

use Rombt\ThemeCore\Composition\Contracts\LifecycleManagerInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;

final class LifecycleManager implements LifecycleManagerInterface
{
    public function shouldStore(string $lifecycle): bool
    {
        return $lifecycle !== ServiceLifecycle::TRANSIENT;
    }
}
