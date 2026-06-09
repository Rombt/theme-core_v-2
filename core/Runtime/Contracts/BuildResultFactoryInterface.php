<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Throwable;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

interface BuildResultFactoryInterface
{
    public function createSuccess(BuildSession $session): BuildResult;

    public function createFailure(
        BuildSession $session,
        Throwable $error
    ): BuildResult;
}
