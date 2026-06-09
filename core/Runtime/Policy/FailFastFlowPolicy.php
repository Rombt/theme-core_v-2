<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Policy;

use Rombt\ThemeCore\Runtime\Contracts\ExecutionFlowPolicyInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class FailFastFlowPolicy implements ExecutionFlowPolicyInterface
{
    public function shouldStopOnFailure(
        BuildSession $session,
        StageResult $result
    ): bool {
        return !$result->isSuccess();
    }
}
