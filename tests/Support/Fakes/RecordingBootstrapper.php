<?php

declare(strict_types=1);

namespace Tests\Support\Fakes;

use Rombt\ThemeCore\Bootstrap\Bootstrappers\BootstrapperInterface;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;

final class RecordingBootstrapper implements BootstrapperInterface
{
    public static array $executionLog = [];

    public function bootstrap(Application $app, Kernel $kernel): void
    {
        self::$executionLog[] = self::class;
    }
}
