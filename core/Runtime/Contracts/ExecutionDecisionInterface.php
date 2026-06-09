<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Throwable;
use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Runtime\Result\StageResult;

interface ExecutionDecisionInterface
{
    public function onStageSuccess(
        BuildSession $session,
        StageResult $result
    ): void;

    public function onStageFailure(
        BuildSession $session,
        Throwable $error,
        ?StageResult $result = null
    ): void;
}
