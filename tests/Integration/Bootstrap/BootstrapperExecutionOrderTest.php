<?php

declare(strict_types=1);

namespace Tests\Integration\Bootstrap;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelContext;
use Tests\Support\Fakes\HighPriorityBootstrapper;
use Tests\Support\Fakes\LowPriorityBootstrapper;
use Tests\Support\Fakes\MediumPriorityBootstrapper;

final class BootstrapperExecutionOrderTest extends TestCase
{
    public function testBootstrappersAreExecutedInPriorityOrder(): void
    {
        $app = new Application();

        $registry = new BootstrapRegistry();

        $registry->register(LowPriorityBootstrapper::class);
        $registry->register(HighPriorityBootstrapper::class);
        $registry->register(MediumPriorityBootstrapper::class);

        $kernel = new Kernel(
            $app,
            $registry,
            new BootstrapperFactory(),
            new KernelContext(),
            dirname(__DIR__, 3),
        );

        $kernel->bootstrap();

        self::assertSame(
            [
                HighPriorityBootstrapper::class,
                MediumPriorityBootstrapper::class,
                LowPriorityBootstrapper::class,
            ],
            $kernel->context()->getExecuted()
        );
    }
}
