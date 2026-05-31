<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\PrioritizedBootstrapperInterface;
use Rombt\ThemeCore\Configuration\Configuration;
use Rombt\ThemeCore\Configuration\ConfigurationState;

final class LoadConfigurationBootstrapper implements PrioritizedBootstrapperInterface
{
    public  static  function priority(): int
    {
        return 90;
    }

    public function bootstrap(
        Application $app,
        Kernel $kernel
    ): void {
        $configuration = new Configuration(
            $kernel->projectRoot()
        );

        $app->set(
            ConfigurationState::CONFIGURATION,
            $configuration
        );
    }
}