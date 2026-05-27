<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

use LogicException;
use Throwable;
use Rombt\ThemeCore\Application\Application;

final class Kernel
{
    private bool $bootstrapped = false;

    public function __construct(
        private readonly Application $app,
        private readonly BootstrapRegistry $bootstrapRegistry,
        private readonly BootstrapperFactory $bootstrapperFactory,
    ) {
    }

    public function bootstrap(): void
    {
        if ($this->bootstrapped) {
            throw new LogicException(
                'Kernel has already been bootstrapped.'
            );
        }

        $this->app->set(
            'kernel.bootstrap.status',
            'bootstrapping'
        );

        $executedBootstrappers = [];

        try {
            foreach ($this->bootstrapRegistry->all() as $bootstrapperClass) {
                $this->app->set(
                    'kernel.bootstrap.current',
                    $bootstrapperClass
                );

                $bootstrapper = $this->bootstrapperFactory->create(
                    $bootstrapperClass
                );

                $bootstrapper->bootstrap($this->app);

                $executedBootstrappers[] = $bootstrapperClass;
            }
        } catch (Throwable $exception) {
            $this->app->set(
                'kernel.bootstrap.status',
                'failed'
            );

            $this->app->set(
                'kernel.bootstrap.failed',
                true
            );

            $this->app->set(
                'kernel.bootstrap.exception',
                $exception
            );

            throw $exception;
        }

        $this->app->set(
            'kernel.bootstrappers.executed',
            $executedBootstrappers
        );

        $this->app->set(
            'kernel.bootstrap.current',
            null
        );

        $this->app->set(
            'kernel.bootstrap.status',
            'bootstrapped'
        );

        $this->bootstrapped = true;
    }

    public function isBootstrapped(): bool
    {
        return $this->bootstrapped;
    }
}