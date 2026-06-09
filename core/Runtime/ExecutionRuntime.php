<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime;

use Throwable;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionDecisionInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineExecutorInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Contracts\StateTransitionInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Session\RuntimeState;

final class ExecutionRuntime
{
    public function __construct(
        private BuildSessionFactoryInterface $sessionFactory,
        private PipelineExecutorInterface $pipelineExecutor,
        private ExecutionDecisionInterface $executionDecision,
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
                $this->executionDecision
            );

            $this->stateTransition->transition(
                $session,
                RuntimeState::COMPLETED
            );

            $result = new BuildResult(
                status: RuntimeState::COMPLETED,
                metadata: [
                    'session_id' => $session->getId(),
                ]
            );

            $session->setBuildResult($result);

            return $result;
        } catch (Throwable $e) {
            $this->stateTransition->transition(
                $session,
                RuntimeState::FAILED
            );

            $result = new BuildResult(
                status: RuntimeState::FAILED,
                error: $e,
                metadata: [
                    'session_id' => $session->getId(),
                ]
            );

            $session->setBuildResult($result);

            return $result;
        }
    }
}
