<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

use LogicException;
use Rombt\ThemeCore\Application\Application;

final class Kernel
{
    private bool $bootstrapped = false;

    public function __construct(
        private readonly Application $app,
        private readonly BootstrapRegistry $bootstrapRegistry,
    ) {
    }

    public function bootstrap(): void
    {
        if ($this->bootstrapped) {
            throw new LogicException(
                'Kernel has already been bootstrapped.'
            );
        }

        $executedBootstrappers = [];

        foreach ($this->bootstrapRegistry->all() as $bootstrapperClass) {
            $bootstrapper = new $bootstrapperClass();

            $bootstrapper->bootstrap($this->app);

            $executedBootstrappers[] = $bootstrapperClass;
        }

        $this->app->set(
            'kernel.bootstrappers.executed',
            $executedBootstrappers
        );

        $this->bootstrapped = true;
    }

    public function isBootstrapped(): bool
    {
        return $this->bootstrapped;
    }
}