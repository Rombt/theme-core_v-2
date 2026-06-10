<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class FailingStage implements StageInterface
{
    public function execute(
        BuildSession $session
    ): StageResult {
        return new StageResult(
            success: false,
            error: new RuntimeException(
                'Intentional test failure'
            )
        );
    }
}
