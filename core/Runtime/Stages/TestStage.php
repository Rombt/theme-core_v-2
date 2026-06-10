<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class TestStage implements StageInterface
{
    public function execute(
        BuildSession $session
    ): StageResult {
        $session->setResource(
            'test_stage',
            'executed'
        );

        return new StageResult(
            success: true
        );
    }
}
