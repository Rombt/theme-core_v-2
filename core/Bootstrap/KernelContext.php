<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

use Rombt\ThemeCore\Application\Application;

final class KernelContext
{
    public function __construct(
        private readonly Application $app,
    ) {
    }

    public function setStatus(KernelBootstrapStatus $status): void
    {
        $this->app->set(
            KernelState::BOOTSTRAP_STATUS,
            $status
        );
    }

    public function getStatus(): ?KernelBootstrapStatus
    {
        $value = $this->app->get(KernelState::BOOTSTRAP_STATUS);

        return $value instanceof KernelBootstrapStatus
            ? $value
            : null;
    }

    public function setCurrent(?string $bootstrapper): void
    {
        $this->app->set(
            KernelState::BOOTSTRAP_CURRENT,
            $bootstrapper
        );
    }

    public function setExecuted(array $bootstrappers): void
    {
        $this->app->set(
            KernelState::BOOTSTRAPPERS_EXECUTED,
            $bootstrappers
        );
    }

    public function setFailed(bool $failed): void
    {
        $this->app->set(
            KernelState::BOOTSTRAP_FAILED,
            $failed
        );
    }

    public function setException(?\Throwable $exception): void
    {
        $this->app->set(
            KernelState::BOOTSTRAP_EXCEPTION,
            $exception
        );
    }
}