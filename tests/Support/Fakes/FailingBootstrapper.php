<?php

declare(strict_types=1);

namespace Tests\Support\Fakes;

use RuntimeException;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\BootstrapperInterface;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;

final class FailingBootstrapper implements BootstrapperInterface
{
    public function bootstrap(Application $app, Kernel $kernel): void
    {
        throw new RuntimeException('Bootstrap failed');
    }
}
