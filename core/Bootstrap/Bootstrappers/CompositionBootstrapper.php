<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Composition\Assembler\RuntimeAssembler;
use Rombt\ThemeCore\Composition\Contracts\ServiceDefinitionProviderInterface;
use Rombt\ThemeCore\Composition\Providers\CoreServiceDefinitionProvider;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;

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

        $providers = [
            new CoreServiceDefinitionProvider(),
        ];

        $definitions = [];

        foreach ($providers as $provider) {
            if (!$provider instanceof ServiceDefinitionProviderInterface) {
                continue;
            }

            foreach ($provider->provide() as $definition) {
                $definitions[] = $definition;
            }
        }

        $runtime = (new RuntimeAssembler())
        ->assemble($definitions);

        $app ->getContextBuilder()->register(
            ApplicationContextKeys::COMPOSITION_RUNTIME,
            $runtime
        );
    }
}
