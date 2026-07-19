<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\RuntimeState;

final class FinalizeBuildStage implements StageInterface
{
    public function execute(
        ExecutionContext $context,
        Application $app,
    ): StageResult {
        try {
            $context
                ->session()
                ->setState(RuntimeState::COMPLETED);

            $context
                ->session()
                ->setBuildResult(
                    new BuildResult(
                        status: 'success',
                        error: null,
                        metadata: [
                            'artifact_count' => $context
                                ->session()
                                ->artifacts()
                                ->count(),
                        ],
                    ),
                );

            return new StageResult(
                success: true,
            );
        } catch (Throwable $e) {
            $context
                ->session()
                ->setState(RuntimeState::FAILED);

            return new StageResult(
                success: false,
                error: $e,
            );
        }
    }
}
