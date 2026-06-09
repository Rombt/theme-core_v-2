<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Session\BuildSession;

interface StateTransitionInterface
{
    public function transition(
        BuildSession $session,
        string $toState
    ): void;
}
