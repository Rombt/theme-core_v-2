<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Pipeline;

use Throwable;
use RuntimeException;
use Rombt\ThemeCore\Runtime\Contracts\PipelineExecutorInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionDecisionInterface;
use Rombt\ThemeCore\Runtime\Contracts\ExecutionFlowPolicyInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class PipelineExecutor implements PipelineExecutorInterface
{
    public function execute(
        PipelineInterface $pipeline,
        BuildSession $session,
        ExecutionDecisionInterface $decision,
        ExecutionFlowPolicyInterface $flowPolicy
    ): void {
        foreach ($pipeline->getStages() as $stage) {
            if (!$stage instanceof StageInterface) {
                throw new RuntimeException('Invalid stage provided');
            }

            $context = new ExecutionContext(
                $session->getId(),
                microtime(true)
            );

            $startedAt = microtime(true);

            try {
                $stageResult = $stage->execute($session, $context);

                $finishedAt = microtime(true);

                // enrich result with runtime metadata (trace layer)
                $enrichedResult = new StageResult(
                    stageName: get_class($stage),
                    success: $stageResult->isSuccess(),
                    context: $context,
                    startedAt: $startedAt,
                    finishedAt: $finishedAt,
                    error: $stageResult->getError(),
                    metadata: $stageResult->getMetadata()
                );

                $session->addStageResult($enrichedResult);

                $decision->onStageSuccess(
                    $session,
                    $enrichedResult
                );

                // flow decision (only on failure)
                if (!$enrichedResult->isSuccess()) {
                    $decision->onStageFailure(
                        $session,
                        $enrichedResult->getError() ?? new RuntimeException('Stage failed'),
                        $enrichedResult
                    );

                    if ($flowPolicy->shouldStopOnFailure($session, $enrichedResult)) {
                        break;
                    }
                }
            } catch (Throwable $e) {
                $finishedAt = microtime(true);

                $failedResult = new StageResult(
                    stageName: get_class($stage),
                    success: false,
                    context: $context,
                    startedAt: $startedAt,
                    finishedAt: $finishedAt,
                    error: $e,
                    metadata: []
                );

                $session->addStageResult($failedResult);

                $decision->onStageFailure(
                    $session,
                    $e,
                    $failedResult
                );

                if ($flowPolicy->shouldStopOnFailure($session, $failedResult)) {
                    break;
                }
            }
        }
    }
}
