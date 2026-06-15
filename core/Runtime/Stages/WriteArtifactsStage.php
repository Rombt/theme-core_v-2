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

final class WriteArtifactsStage implements StageInterface
{
    public function __construct(
        private readonly DiagnosticsService $diagnostics
    ) {
    }

    public function execute(
        ExecutionContext $context
    ): StageResult {
        $session = $context->session();

        $artifacts = $session->getResource(
            'artifacts'
        );

        if ($artifacts === null) {
            return new StageResult(
                success: false,
                error: new RuntimeException(
                    'Artifacts resource not found'
                )
            );
        }

        $entry = $this->diagnostics->create(
            level: DiagnosticLevel::INFO,
            message: 'Writing artifacts',
            context: new DiagnosticContext([
                'stage' => self::class,
            ])
        );

        // $session->getLogger()->write($entry);

        foreach ($artifacts as $artifact) {
            $entry = $this->diagnostics->create(
                level: DiagnosticLevel::INFO,
                message: 'Artifact written',
                context: new DiagnosticContext([
                    'stage' => self::class,
                    'artifact' => $artifact['path'],
                ])
            );

            // $session->getLogger()->write($entry);

            // $session->getDiagnostics()->add(
            //     sprintf(
            //         'Artifact "%s" written',
            //         $artifact['path']
            //     )
            // );
        }

        return new StageResult(
            success: true
        );
    }
}
