<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

use Rombt\ThemeCore\Bootstrap\Bootstrappers\BootstrapperInterface;

final class BootstrapperFactory
{
    /**
     * @param class-string<BootstrapperInterface> $bootstrapper
     */
    public function create( string $bootstrapper, ): BootstrapperInterface {
        return new $bootstrapper();
    }
}