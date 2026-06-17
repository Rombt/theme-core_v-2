<?php

declare(strict_types=1);

namespace Tests\Integration\Bootstrap;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelBootstrapStatus;
use Rombt\ThemeCore\Bootstrap\KernelContext;
use Tests\Support\Fakes\SimpleBootstrapper;

final class KernelContextTest extends TestCase
{
    public function testKernelContextAfterSuccessfulBootstrap(): void
    {
        $app = new Application();

        $registry = new BootstrapRegistry();
        $registry->register(SimpleBootstrapper::class);

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
            KernelBootstrapStatus::BOOTSTRAPPED,
            $context->getStatus()
        );

        self::assertFalse(
            $context->isFailed()
        );

        self::assertSame(
            [SimpleBootstrapper::class],
            $context->getExecuted()
        );
    }

    public function testKernelContextOnBootstrapFailure(): void
    {
        $this->expectException(\RuntimeException::class);

        $app = new Application();

        $registry = new BootstrapRegistry();
        $registry->register(\Tests\Support\Fakes\FailingBootstrapper::class);

        $kernel = new Kernel(
            $app,
            $registry,
            new BootstrapperFactory(),
            new KernelContext($app),
            dirname(__DIR__, 3),
        );

        try {
            $kernel->bootstrap();
        } catch (\Throwable $e) {
            $context = $kernel->context();

            self::assertSame(
                KernelBootstrapStatus::FAILED,
                $context->getStatus()
            );

            self::assertTrue(
                $context->isFailed()
            );

            self::assertNotNull(
                $context->getException()
            );

            throw $e;
        }
    }
}
