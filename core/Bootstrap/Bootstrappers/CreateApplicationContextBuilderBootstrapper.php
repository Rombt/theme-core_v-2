<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\ApplicationContextBuilder;
use Rombt\ThemeCore\Bootstrap\Kernel;

final class CreateApplicationContextBuilderBootstrapper implements PrioritizedBootstrapperInterface
{
    public static function priority(): int
    {
        return 1000;
    }

    public function bootstrap(Application $app, Kernel $kernel): void
    {
        $app->setContextBuilder(new ApplicationContextBuilder());
    }
}
