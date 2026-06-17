<?php

declare(strict_types=1);

namespace Tests\Integration\Bootstrap;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Tests\Support\Fakes\SimpleBootstrapper;

final class BootstrapRegistryTest extends TestCase
{
    public function testBootstrapperCanBeRegistered(): void
    {
        $registry = new BootstrapRegistry();

        $registry->register(SimpleBootstrapper::class);

        self::assertTrue(
            is_subclass_of(
                SimpleBootstrapper::class,
                \Rombt\ThemeCore\Bootstrap\Bootstrappers\BootstrapperInterface::class
            )
        );


        self::assertTrue(
            $registry->has(SimpleBootstrapper::class)
        );
    }

    public function testBootstrapRegistryReturnsAllBootstrappers(): void
    {
        $registry = new BootstrapRegistry();

        $registry->register(SimpleBootstrapper::class);

        self::assertSame(
            [SimpleBootstrapper::class],
            $registry->all()
        );
    }
}
