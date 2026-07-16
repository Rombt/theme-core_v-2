<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;

final class BuildThemeComponentsStage implements StageInterface
{
    public function execute(
        ExecutionContext $context,
        Application $app,
    ): StageResult {
        try {
            // TODO: Build Theme Components.

            return new StageResult(
                success: true,
            );
        } catch (Throwable $e) {
            return new StageResult(
                success: false,
                error: $e,
            );
        }
    }
}
