<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Providers;

use Rombt\ThemeCore\Composition\Contracts\ServiceDefinitionProviderInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\Configuration\Configuration;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Contracts\Logging\LogFormatterInterface;
use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;
use Rombt\ThemeCore\Infrastructure\Logging\Formatters\JsonFormatter;
use Rombt\ThemeCore\Infrastructure\Logging\StructuredLogger;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\ConsoleWriter;

final class CoreServiceDefinitionProvider implements ServiceDefinitionProviderInterface
{
    public function provide(): array
    {
        return [
            new ServiceDefinition(
                identifier: DiagnosticsService::class,
                class: DiagnosticsService::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

            new ServiceDefinition(
                identifier: JsonFormatter::class,
                class: JsonFormatter::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

            new ServiceDefinition(
                identifier: ConsoleWriter::class,
                class: ConsoleWriter::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

            new ServiceDefinition(
                identifier: StructuredLogger::class,
                class: StructuredLogger::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: [
                    JsonFormatter::class,
                    ConsoleWriter::class,
                ]
            ),
        ];
    }
}
