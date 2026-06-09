<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime;

use Rombt\ThemeCore\Runtime\Contracts\BuildResultFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionDecisionInterface;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionFlowPolicyInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineExecutorInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Contracts\StateTransitionInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Session\RuntimeState;
use Throwable;

final class ExecutionRuntime
{
    public function __construct(
        private BuildSessionFactoryInterface $sessionFactory,
        private BuildResultFactoryInterface $resultFactory,
        private PipelineExecutorInterface $pipelineExecutor,
        private ExecutionDecisionInterface $executionDecision,
        private ExecutionFlowPolicyInterface $flowPolicy,
        private StateTransitionInterface $stateTransition
    ) {
    }

    public function run(PipelineInterface $pipeline): BuildResult
    {
        $session = $this->sessionFactory->create();

        try {
            $this->stateTransition->transition(
                $session,
                RuntimeState::RUNNING
            );

            $this->pipelineExecutor->execute(
                $pipeline,
                $session,
                $this->executionDecision,
                $this->flowPolicy
            );

            $this->stateTransition->transition(
                $session,
                RuntimeState::COMPLETED
            );

            return $this->resultFactory->createSuccess($session);
        } catch (Throwable $e) {
            $this->executionDecision->onStageFailure($session, $e);

            $this->stateTransition->transition(
                $session,
                RuntimeState::FAILED
            );

            return $this->resultFactory->createFailure($session, $e);
        }
    }
}
