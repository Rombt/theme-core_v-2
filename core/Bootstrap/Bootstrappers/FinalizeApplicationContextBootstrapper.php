<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;

final class FinalizeApplicationContextBootstrapper implements PrioritizedBootstrapperInterface
{
    public static function priority(): int
    {
        return 0;
    }

    public function bootstrap(
        Application $app,
        Kernel $kernel
    ): void {
        $app->setContext(
            $app->getContextBuilder()->build()
        );
    }
}
