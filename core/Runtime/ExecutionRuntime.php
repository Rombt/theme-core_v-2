<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Runtime\Contracts\BuildResultFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineExecutorInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Session\RuntimeState;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;

final class ExecutionRuntime
{
    public function __construct(
        private BuildSessionFactoryInterface $sessionFactory,
        private BuildResultFactoryInterface $resultFactory,
        private PipelineExecutorInterface $pipelineExecutor,
        private LoggerInterface $logger,
    ) {
    }

    public function run(PipelineInterface $pipeline): BuildResult
    {
        $session = $this->sessionFactory->create($this->logger);

        try {
            $session->setState(RuntimeState::RUNNING);

            $success = $this->pipelineExecutor->execute(
                $pipeline,
                $session
            );

            if (!$success) {
                $session->setState(RuntimeState::FAILED);

                $result = $this->resultFactory->createFailure(
                    $session,
                    new RuntimeException('Pipeline execution failed')
                );

                $session->setBuildResult($result);

                return $result;
            }

            $session->setState(RuntimeState::COMPLETED);

            $result = $this->resultFactory->createSuccess($session);

            $session->setBuildResult($result);

            return $result;
        } catch (Throwable $e) {
            $session->setState(RuntimeState::FAILED);

            $result = $this->resultFactory->createFailure($session, $e);

            $session->setBuildResult($result);

            return $result;
        }
    }
}
