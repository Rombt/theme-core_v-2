<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Result\StageResult;

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
        $artifacts = $context
            ->session()
            ->artifacts();

        $this->diagnostics->create(
            level: DiagnosticLevel::INFO,
            message: 'Writing artifacts',
            context: new DiagnosticContext([
                'stage' => self::class,
            ])
        );

        foreach ($artifacts as $artifact) {

            /** @var Artifact $artifact */
            $this->diagnostics->create(
                level: DiagnosticLevel::INFO,
                message: 'Artifact written',
                context: new DiagnosticContext([
                    'stage' => self::class,
                    'artifact' => $artifact->destination(),
                ])
            );
        }

        return new StageResult(
            success: true
        );
    }
}
