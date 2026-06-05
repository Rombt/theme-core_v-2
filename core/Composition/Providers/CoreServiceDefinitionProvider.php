<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Providers;

use Rombt\ThemeCore\Composition\Contracts\ServiceDefinitionProviderInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\Configuration\Configuration;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;

final class CoreServiceDefinitionProvider implements ServiceDefinitionProviderInterface
{
    public function provide(): array
    {
        return [
            new ServiceDefinition(
                identifier: Configuration::class,
                class: Configuration::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

            new ServiceDefinition(
                identifier: DiagnosticsService::class,
                class: DiagnosticsService::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),
        ];
    }
}
