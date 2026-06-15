<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Context;

use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class ExecutionContext
{
    public function __construct(
        private readonly BuildSession $session,
        private readonly CompositionRuntimeInterface $compositionRuntime,
    ) {
    }

    public function session(): BuildSession
    {
        return $this->session;
    }

    public function composition(): CompositionRuntimeInterface
    {
        return $this->compositionRuntime;
    }

    public function service(string $id): object
    {


        return $this->compositionRuntime->services()->get($id);
    }
}
