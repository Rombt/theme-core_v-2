<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Pipeline;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionDecisionInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineExecutorInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class PipelineExecutor implements PipelineExecutorInterface
{
    public function execute(
        PipelineInterface $pipeline,
        BuildSession $session,
        ExecutionDecisionInterface $decision
    ): void {
        foreach ($pipeline->getStages() as $stage) {
            if (!$stage instanceof StageInterface) {
                throw new RuntimeException('Invalid stage provided');
            }

            try {
                $result = $stage->execute($session);

                $decision->onStageSuccess(
                    $session,
                    $result
                );

                if (!$result->isSuccess()) {
                    $decision->onStageFailure(
                        $session,
                        $result->getError()
                            ?? new RuntimeException('Stage failed'),
                        $result
                    );

                    break;
                }
            } catch (Throwable $e) {
                $failedResult = new StageResult(
                    success: false,
                    error: $e
                );

                $decision->onStageFailure(
                    $session,
                    $e,
                    $failedResult
                );

                break;
            }
        }
    }
}
