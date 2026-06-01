<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;

interface BootstrapperInterface
{
    public function bootstrap(Application $app, Kernel $kernel): void;
}
