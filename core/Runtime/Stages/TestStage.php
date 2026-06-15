<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;

final class TestStage implements StageInterface
{
    public function execute(
        ExecutionContext $context
    ): StageResult {

        $session = $context->session();
        $session->setResource(
            'test_stage',
            'executed'
        );

        return new StageResult(
            success: true
        );
    }
}
