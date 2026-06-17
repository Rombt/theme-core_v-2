<?php

declare(strict_types=1);

namespace Tests\Integration\Composition;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\Composition\Registry\ServiceRegistry;
use Tests\Support\Fakes\DummyService;

final class ServiceRegistryTest extends TestCase
{
    public function testServiceCanBeRegisteredAndRetrieved(): void
    {
        $registry = new ServiceRegistry();

        $definition = new ServiceDefinition(
            identifier: DummyService::class,
            class: DummyService::class,
            lifecycle: ServiceLifecycle::LAZY,
            dependencies: []
        );

        $registry->register($definition);

        self::assertTrue(
            $registry->has(DummyService::class)
        );

        self::assertSame(
            $definition,
            $registry->get(DummyService::class)
        );
    }
}
