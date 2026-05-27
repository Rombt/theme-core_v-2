<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;

interface BootstrapperInterface
{
    public function bootstrap(Application $app): void;
}