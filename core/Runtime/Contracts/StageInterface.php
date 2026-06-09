<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

interface StageInterface
{
    public function execute(
        BuildSession $session,
        ExecutionContext $context
    ): mixed;
}
