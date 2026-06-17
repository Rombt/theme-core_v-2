<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;
use Rombt\ThemeCore\Application\Application;

final class TestStage implements StageInterface
{
    public function execute(
        ExecutionContext $context,
        Application $app
    ): StageResult {

        $session = $context->session();
        $logger = $context->service(LoggerInterface::class);
        $diagnostics = $context->service(DiagnosticsService::class);

        $session->setResource(
            'test_stage',
            'executed'
        );


        echo '$session = ';
        print_r($session);
        echo PHP_EOL;


        echo '$context = ';
        print_r($context);
        echo PHP_EOL;

        return new StageResult(
            success: true
        );
    }
}
