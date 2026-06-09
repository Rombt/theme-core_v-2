<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Policy;

use Throwable;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionPolicyInterface;
use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Runtime\Session\RuntimeState;
use Rombt\ThemeCore\Runtime\Contracts\StateTransitionInterface;

final class FailFastExecutionPolicy implements ExecutionPolicyInterface
{
    public function __construct(
        private StateTransitionInterface $transition
    ) {
    }

    public function handle(Throwable $error, BuildSession $session): void
    {
        $this->transition->transition($session, RuntimeState::FAILED);
    }

    public function shouldContinue(Throwable $error): bool
    {
        return false;
    }
}
