<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticCollector;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticReportBuilder;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;

final class CreateDiagnosticsBootstrapper implements PrioritizedBootstrapperInterface
{
    public static function priority(): int
    {
        return 85;
    }

    public function bootstrap(
        Application $app,
        Kernel $kernel
    ): void {

        $collector = new DiagnosticCollector();

        $app->getContextBuilder()->register(
            ApplicationContextKeys::DIAGNOSTICS,
            new DiagnosticsService(
                $collector,
                new DiagnosticReportBuilder(),
            )
        );
    }
}
