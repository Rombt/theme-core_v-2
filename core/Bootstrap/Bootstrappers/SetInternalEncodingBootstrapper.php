<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\PrioritizedBootstrapperInterface;
use Rombt\ThemeCore\Bootstrap\Kernel;

final class SetInternalEncodingBootstrapper implements PrioritizedBootstrapperInterface
{
    public static function priority(): int
    {
        return 100;
    }

    public function bootstrap(Application $app, Kernel $kernel): void
    {
        mb_internal_encoding('UTF-8');
    }
}
