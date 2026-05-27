<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;

final class SetInternalEncodingBootstrapper implements BootstrapperInterface
{
    public function bootstrap(Application $app): void
    {
        mb_internal_encoding('UTF-8');

        $app->set('encoding.internal', mb_internal_encoding());
    }
}