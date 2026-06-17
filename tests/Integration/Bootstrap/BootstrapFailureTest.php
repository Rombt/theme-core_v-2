<?php

declare(strict_types=1);

namespace Tests\Integration\Bootstrap;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\KernelContext;
use Tests\Support\Fakes\FailingBootstrapper;

final class BootstrapFailureTest extends TestCase
{
    public function testKernelHandlesBootstrapFailure(): void
    {
        $this->expectException(RuntimeException::class);

        $app = new Application();

        $registry = new BootstrapRegistry();
        $registry->register(FailingBootstrapper::class);

        $kernel = new Kernel(
            $app,
            $registry,
            new BootstrapperFactory(),
            new KernelContext($app),
            dirname(__DIR__, 3),
        );

        $kernel->bootstrap();
    }
}
