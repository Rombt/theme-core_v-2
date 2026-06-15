<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Context;

use Rombt\ThemeCore\Runtime\Contracts\ExecutionContextFactoryInterface;
use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;

final class ExecutionContextFactory implements ExecutionContextFactoryInterface
{
    public function create(
        BuildSession $session,
        CompositionRuntimeInterface $compositionRuntime
    ): ExecutionContext {
        return new ExecutionContext(
            $session,
            $compositionRuntime
        );
    }
}
