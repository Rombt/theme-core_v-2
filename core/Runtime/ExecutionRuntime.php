<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionRuntimeInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildResultFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineExecutorInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Runtime\Session\RuntimeState;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;

final class ExecutionRuntime implements ExecutionRuntimeInterface
{
    public function __construct(
        private readonly BuildResultFactoryInterface $resultFactory,
        private readonly PipelineExecutorInterface $pipelineExecutor,
    ) {
    }

    public function run(ExecutionContext $context, PipelineInterface $pipeline): BuildResult
    {

        $session = $context->session();

        try {
            $success = $this->pipelineExecutor->execute($pipeline, $context);

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
