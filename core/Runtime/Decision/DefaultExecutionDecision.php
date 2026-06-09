<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Decision;

use Throwable;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionDecisionInterface;
use Rombt\ThemeCore\Runtime\Contracts\StateTransitionInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Runtime\Session\RuntimeState;

final class DefaultExecutionDecision implements ExecutionDecisionInterface
{
    public function __construct(
        private StateTransitionInterface $transition
    ) {
    }

    public function onStageSuccess(
        BuildSession $session,
        StageResult $result
    ): void {
        // no-op (runtime does not mutate state on success)
    }

    public function onStageFailure(
        BuildSession $session,
        Throwable $error,
        ?StageResult $result = null
    ): void {
        if ($session->getState() !== RuntimeState::FAILED) {
            $this->transition->transition(
                $session,
                RuntimeState::FAILED
            );
        }
    }
}
