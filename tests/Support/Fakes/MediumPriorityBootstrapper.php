<?php

declare(strict_types=1);

namespace Tests\Support\Fakes;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\PrioritizedBootstrapperInterface;
use Rombt\ThemeCore\Bootstrap\Kernel;

final class MediumPriorityBootstrapper implements PrioritizedBootstrapperInterface
{
    public static function priority(): int
    {
        return 200;
    }

    public function bootstrap(Application $app, Kernel $kernel): void
    {
    }
}
