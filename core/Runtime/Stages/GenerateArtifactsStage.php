<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Result\StageResult;

final class GenerateArtifactsStage implements StageInterface
{
    public function __construct(
        private readonly DiagnosticsService $diagnostics
    ) {
    }

    public function execute(ExecutionContext $context, Application $app): StageResult
    {
        $session = $context->session();

        /** @var array{name: string, version: string}|null $theme */
        $theme = $session->getResource('theme');

        if (!is_array($theme)) {
            return new StageResult(
                success: false,
                error: new RuntimeException(
                    'Theme resource not found'
                )
            );
        }

        $this->diagnostics->create(
            level: DiagnosticLevel::INFO,
            message: 'Generating artifacts',
            context: new DiagnosticContext([
                'stage' => self::class,
            ])
        );

        $artifacts = $session->artifacts();

        $artifacts->add(
            new Artifact(
                id: new ArtifactId('style-css'),
                type: ArtifactType::FILE,
                destination: 'style.css',
                content: sprintf(
                    'Theme: %s%sVersion: %s',
                    $theme['name'],
                    PHP_EOL,
                    $theme['version']
                )
            )
        );

        $artifacts->add(
            new Artifact(
                id: new ArtifactId('functions-php'),
                type: ArtifactType::FILE,
                destination: 'functions.php',
                content: '<?php'
            )
        );

        $artifacts->add(
            new Artifact(
                id: new ArtifactId('theme-json'),
                type: ArtifactType::FILE,
                destination: 'theme.json',
                content: json_encode(
                    [
                        'version' => 3,
                    ],
                    JSON_THROW_ON_ERROR
                )
            )
        );

        return new StageResult(
            success: true
        );
    }
}
