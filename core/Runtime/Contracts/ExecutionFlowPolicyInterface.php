<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Runtime\Result\StageResult;

interface ExecutionFlowPolicyInterface
{
    public function shouldStopOnFailure(
        BuildSession $session,
        StageResult $result
    ): bool;
}
