<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;

final class BuildThemeStage implements StageInterface
{
    public function execute(ExecutionContext $context, Application $app): StageResult
    {
        $session = $context->session();

        /** @var LoggerInterface $logger */
        $logger = $context->service(LoggerInterface::class);

        /** @var DiagnosticsService $diagnostics */
        $diagnostics = $context->service(DiagnosticsService::class);

        /** @var array<string, mixed>|null $configuration */
        $configuration = $session->getResource('configuration');

        if (!is_array($configuration)) {
            return new StageResult(
                success: false,
                error: new RuntimeException(
                    'Configuration resource not found'
                )
            );
        }

        $entry = $diagnostics->create(
            level: DiagnosticLevel::INFO,
            message: 'Building theme model',
            context: new DiagnosticContext([
                'stage' => self::class,
            ])
        );

        $logger->write($entry);

        $theme = [
            'name' => $configuration['theme'] ?? '',
            'version' => $configuration['version'] ?? '',
        ];

        $session->setResource('theme', $theme);

        /** @var DiagnosticsService $diagnostics */
        $diagnostics->create(
            level: DiagnosticLevel::INFO,
            message: 'Theme model created',
            context: new DiagnosticContext([
                'stage' => self::class,
            ])
        );

        return new StageResult(success: true);
    }
}
