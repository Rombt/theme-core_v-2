<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class LoadConfigurationStage implements StageInterface
{
    public function __construct(
        private readonly DiagnosticsService $diagnostics
    ) {
    }

    public function execute(
        BuildSession $session
    ): StageResult {
        $entry = $this->diagnostics->create(
            level: DiagnosticLevel::INFO,
            message: 'Loading configuration',
            context: new DiagnosticContext([
                'stage' => self::class,
            ])
        );

        $session->getLogger()->write($entry);

        $configuration = [
            'theme' => 'theme-core',
            'version' => '2.0.0',
        ];

        $session->setResource(
            'configuration',
            $configuration
        );

        $session->getDiagnostics()->add(
            'Configuration loaded'
        );

        return new StageResult(
            success: true
        );
    }
}
