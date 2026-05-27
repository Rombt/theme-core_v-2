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
            KernelState::BOOTSTRAP_STATUS,
            KernelBootstrapStatus::BOOTSTRAPPING
        );

        $executedBootstrappers = [];

        try {
            foreach ($this->bootstrapRegistry->all() as $bootstrapperClass) {
                $this->app->set(
                    KernelState::BOOTSTRAP_CURRENT,
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
                KernelState::BOOTSTRAP_STATUS,
                KernelBootstrapStatus::FAILED
            );

            $this->app->set(
                KernelState::BOOTSTRAP_FAILED,
                true
            );

            $this->app->set(
                KernelState::BOOTSTRAP_EXCEPTION,
                $exception
            );

            throw $exception;
        }

        $this->app->set(
            KernelState::BOOTSTRAPPERS_EXECUTED,
            $executedBootstrappers
        );

        $this->app->set(
            KernelState::BOOTSTRAP_CURRENT,
            null
        );

        $this->app->set(
            KernelState::BOOTSTRAP_STATUS,
            KernelBootstrapStatus::BOOTSTRAPPED
        );

        $this->bootstrapped = true;
    }

    public function isBootstrapped(): bool
    {
        return $this->bootstrapped;
    }
}