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

        $this->assertTrue(
            $registry->has(SimpleBootstrapper::class)
        );
    }

    public function testBootstrapRegistryReturnsAllBootstrappers(): void
    {
        $registry = new BootstrapRegistry();

        $registry->register(SimpleBootstrapper::class);

        $this->assertSame(
            [SimpleBootstrapper::class],
            $registry->all()
        );
    }
}
