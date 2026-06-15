<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;

final class FailingStage implements StageInterface
{
    public function execute(
        ExecutionContext $context
    ): StageResult {
        return new StageResult(
            success: false,
            error: new RuntimeException(
                'Intentional test failure'
            )
        );
    }
}
