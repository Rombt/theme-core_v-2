<?php

declare(strict_types=1);

namespace Tests\Support\Fakes;

use Rombt\ThemeCore\Composition\Contracts\LifecycleManagerInterface;

final class DummyLifecycleManager implements LifecycleManagerInterface
{
    public function shouldStore(string $lifecycle): bool
    {
        return true;
    }
}
