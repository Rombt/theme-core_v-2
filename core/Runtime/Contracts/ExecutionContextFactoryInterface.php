<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;

interface ExecutionContextFactoryInterface
{
    public function create(
        BuildSession $session,
        CompositionRuntimeInterface $compositionRuntime
    ): ExecutionContext;
}
