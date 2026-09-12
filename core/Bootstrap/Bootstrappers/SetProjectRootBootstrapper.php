<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\ApplicationContextBuilder;
use Rombt\ThemeCore\Application\ProjectRoot;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Bootstrap\Kernel;

final class SetProjectRootBootstrapper implements PrioritizedBootstrapperInterface
{
    public static function priority(): int
    {
        return 95;
    }

    public function bootstrap(
        Application $app,
        Kernel $kernel
    ): void {
        $app->getContextBuilder()->register(
            ApplicationContextKeys::PROJECT_ROOT,
            new ProjectRoot(
                $kernel->projectRoot(),
            ),
        );
    }
}
