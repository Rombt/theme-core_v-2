<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class BuildThemeStage implements StageInterface
{
    public function __construct(
        private readonly DiagnosticsService $diagnostics
    ) {
    }

    public function execute(
        BuildSession $session
    ): StageResult {
        $configuration = $session->getResource(
            'configuration'
        );

        if ($configuration === null) {
            return new StageResult(
                success: false,
                error: new RuntimeException(
                    'Configuration resource not found'
                )
            );
        }

        $entry = $this->diagnostics->create(
            level: DiagnosticLevel::INFO,
            message: 'Building theme model',
            context: new DiagnosticContext([
                'stage' => self::class,
            ])
        );

        $session->getLogger()->write($entry);

        $theme = [
            'name' => $configuration['theme'],
            'version' => $configuration['version'],
        ];

        $session->setResource(
            'theme',
            $theme
        );

        $session->getDiagnostics()->add(
            'Theme model created'
        );

        return new StageResult(
            success: true
        );
    }
}
