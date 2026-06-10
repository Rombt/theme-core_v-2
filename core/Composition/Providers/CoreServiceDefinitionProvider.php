<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Providers;

use Rombt\ThemeCore\Composition\Contracts\ServiceDefinitionProviderInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Infrastructure\Logging\Formatters\JsonFormatter;
use Rombt\ThemeCore\Infrastructure\Logging\StructuredLogger;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\ConsoleWriter;
use Rombt\ThemeCore\Runtime\ExecutionRuntime;
use Rombt\ThemeCore\Runtime\Pipeline\PipelineExecutor;
use Rombt\ThemeCore\Runtime\Result\BuildResultFactory;
use Rombt\ThemeCore\Runtime\Session\BuildSessionFactory;

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

            new ServiceDefinition(
                identifier: BuildSessionFactory::class,
                class: BuildSessionFactory::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

            new ServiceDefinition(
                identifier: BuildResultFactory::class,
                class: BuildResultFactory::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

            new ServiceDefinition(
                identifier: PipelineExecutor::class,
                class: PipelineExecutor::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

            new ServiceDefinition(
                identifier: ExecutionRuntime::class,
                class: ExecutionRuntime::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: [
                    BuildSessionFactory::class,
                    BuildResultFactory::class,
                    PipelineExecutor::class,
                    StructuredLogger::class,
                ]
            ),
        ];
    }
}
