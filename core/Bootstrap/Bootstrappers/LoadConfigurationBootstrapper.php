<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\PrioritizedBootstrapperInterface;
use Rombt\ThemeCore\Configuration\Configuration;
use Rombt\ThemeCore\Configuration\ConfigurationSchema;
use Rombt\ThemeCore\Configuration\ConfigurationDiscovery;
use Rombt\ThemeCore\Configuration\ConfigurationLoader;
use Rombt\ThemeCore\Configuration\ConfigurationValidator;
use Rombt\ThemeCore\Configuration\ConfigurationDefaultsApplier;
use Rombt\ThemeCore\Configuration\ConfigurationNormalizer;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;

final class LoadConfigurationBootstrapper implements PrioritizedBootstrapperInterface
{
    public static function priority(): int
    {
        return 90;
    }

    public function bootstrap(
        Application $app,
        Kernel $kernel
    ): void {

        $schema = new ConfigurationSchema();
        $discovery = new ConfigurationDiscovery();
        $loader = new ConfigurationLoader();
        $validator = new ConfigurationValidator($schema);

        $defaultsApplier = new ConfigurationDefaultsApplier($schema);
        $normalizer = new ConfigurationNormalizer($kernel->projectRoot());
        $path = $discovery->discover($kernel->projectRoot());
        $configuration = $loader->load($path);
        $validator->validate($configuration);
        $configuration = $defaultsApplier->apply($configuration);
        $configuration = $normalizer->normalize($configuration);

        $app->getContextBuilder()->register(
            ApplicationContextKeys::CONFIGURATION,
            new Configuration($configuration)
        );
    }
}
