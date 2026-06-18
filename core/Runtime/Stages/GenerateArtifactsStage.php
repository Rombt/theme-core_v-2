<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;

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

        $artifacts = [
            [
                'path' => 'style.css',
                'content' => sprintf(
                    'Theme: %s%sVersion: %s',
                    $theme['name'],
                    PHP_EOL,
                    $theme['version']
                ),
            ],
            [
                'path' => 'functions.php',
                'content' => '<?php',
            ],
            [
                'path' => 'theme.json',
                'content' => json_encode(
                    [
                        'version' => 3,
                    ],
                    JSON_THROW_ON_ERROR
                ),
            ],
        ];

        $session->setResource(
            'artifacts',
            $artifacts
        );

        return new StageResult(
            success: true
        );
    }
}
