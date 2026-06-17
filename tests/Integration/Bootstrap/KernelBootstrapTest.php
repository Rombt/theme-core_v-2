<?php

declare(strict_types=1);

namespace Tests\Integration\Bootstrap;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\CreateLoggerBootstrapper;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\LoadConfigurationBootstrapper;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Tests\Support\Builders\TestApplicationBuilder;
use Tests\Support\Builders\TestBootstrapBuilder;

final class KernelBootstrapTest extends TestCase
{
    public function testKernelBootstrapsSuccessfully(): void
    {
        $app = TestApplicationBuilder::create()->build();

        $kernel = TestBootstrapBuilder::create()
            ->addBootstrapper(LoadConfigurationBootstrapper::class)
            ->addBootstrapper(CreateLoggerBootstrapper::class)
            ->build($app);

        $kernel->bootstrap();

        $context = $app->getContext();

        self::assertTrue(
            $context->has(ApplicationContextKeys::LOGGER)
        );
    }
}
