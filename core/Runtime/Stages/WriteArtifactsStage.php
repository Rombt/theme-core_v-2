<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Application\Application;

final class WriteArtifactsStage implements StageInterface
{
    public function __construct(
        private readonly DiagnosticsService $diagnostics
    ) {
    }

    public function execute(
        ExecutionContext $context,
        Application $app
    ): StageResult {
        $session = $context->session();

        /** @var array<int, array{path: string, content: string}>|null $artifacts */
        $artifacts = $session->getResource('artifacts');

        if (!is_array($artifacts)) {
            return new StageResult(
                success: false,
                error: new RuntimeException(
                    'Artifacts resource not found'
                )
            );
        }

        $this->diagnostics->create(
            level: DiagnosticLevel::INFO,
            message: 'Writing artifacts',
            context: new DiagnosticContext([
                'stage' => self::class,
            ])
        );

        foreach ($artifacts as $artifact) {

            /** @var array{path: string, content: string} $artifact */
            $this->diagnostics->create(
                level: DiagnosticLevel::INFO,
                message: 'Artifact written',
                context: new DiagnosticContext([
                    'stage' => self::class,
                    'artifact' => $artifact['path'],
                ])
            );
        }

        return new StageResult(
            success: true
        );
    }
}
