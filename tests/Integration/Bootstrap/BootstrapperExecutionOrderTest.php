<?php

declare(strict_types=1);

namespace Tests\Integration\Bootstrap;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelContext;
use Tests\Support\Fakes\RecordingBootstrapper;

final class BootstrapperExecutionOrderTest extends TestCase
{
    public function testBootstrappersAreExecutedInPriorityOrder(): void
    {
        $app = new Application();

        $registry = new BootstrapRegistry();
        $registry->register(RecordingBootstrapper::class . ':1');
        $registry->register(RecordingBootstrapper::class . ':2');
        $registry->register(RecordingBootstrapper::class . ':3');

        $kernel = new Kernel(
            $app,
            $registry,
            new BootstrapperFactory(),
            new KernelContext($app),
            dirname(__DIR__, 3),
        );

        $kernel->bootstrap();

        $context = $kernel->context();

        self::assertSame(
            ['3', '2', '1'],
            $context->getExecuted()
        );
    }
}
