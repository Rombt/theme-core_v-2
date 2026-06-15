<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Pipeline;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\PipelineExecutorInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;

final class PipelineExecutor implements PipelineExecutorInterface
{
    public function execute(
        PipelineInterface $pipeline,
        ExecutionContext $context
    ): bool {
        foreach ($pipeline->getStages() as $stage) {
            if (!$stage instanceof StageInterface) {
                throw new RuntimeException(
                    'Invalid stage provided'
                );
            }

            try {
                $result = $stage->execute(
                    $context
                );

                if (!$result->isSuccess()) {
                    throw $result->getError()
                        ?? new RuntimeException('Stage failed');
                }
            } catch (Throwable $e) {
                throw $e;
            }
        }

        return true;
    }
}
