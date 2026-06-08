<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Composition\Assembler\RuntimeAssembler;
use Rombt\ThemeCore\Composition\Providers\CoreServiceDefinitionProvider;
use Rombt\ThemeCore\Composition\Contracts\ServiceDefinitionProviderInterface;

final class CompositionBootstrapper implements BootstrapperInterface, PrioritizedBootstrapperInterface
{
    public static function priority(): int
    {
        return 80;
    }

    public function bootstrap(
        Application $app,
        Kernel $kernel
    ): void {

        // 1. Providers (source of truth)
        $providers = [
            new CoreServiceDefinitionProvider(),
        ];

        // 2. Collect definitions
        $definitions = [];

        foreach ($providers as $provider) {
            if (!$provider instanceof ServiceDefinitionProviderInterface) {
                continue;
            }

            foreach ($provider->provide() as $definition) {
                $definitions[] = $definition;
            }
        }

        // 3. Build runtime (ALL DI LOGIC INSIDE ASSEMBLER)
        $runtime = (new RuntimeAssembler())->assemble($definitions);

        // 4. Store runtime
        $app->set('composition.runtime', $runtime);

        $app->set('composition.bootstrapper.loaded', true);
    }
}
