<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
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

            $diagnostics = $app->getContext()->get(ApplicationContextKeys::DIAGNOSTICS);
            if (!$diagnostics instanceof DiagnosticsService) {
                throw new \RuntimeException('Diagnostics service is unavailable.');
            }

            $warningCount = $diagnostics->report()->severities()['warning'] ?? 0;
            $status = $warningCount > 0 ? 'completed_with_warnings' : 'success';

            $context
                ->session()
                ->setBuildResult(
                    new BuildResult(
                        status: $status,
                        error: null,
                        metadata: [
                            'artifact_count' => $context
                                ->session()
                                ->artifacts()
                                ->count(),
                            'warning_count' => $warningCount,
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
