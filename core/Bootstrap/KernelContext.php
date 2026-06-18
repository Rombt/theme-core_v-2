<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;

final class KernelContext
{
    private ?KernelBootstrapStatus $status = null;

    private ?string $currentBootstrapper = null;

    /**
     * @var array<int,string>
     */
    private array $executedBootstrappers = [];

    private bool $failed = false;

    private ?\Throwable $exception = null;

    /**
     * @var array<int, ServiceDefinition>
     */
    private array $serviceDefinitions = [];

    /**
     * @param array<int, ServiceDefinition> $definitions
     */
    public function setServiceDefinitions(array $definitions): void
    {
        $this->serviceDefinitions = $definitions;
    }

    /**
     * @return array<int, ServiceDefinition>
     */
    public function getServiceDefinitions(): array
    {
        return $this->serviceDefinitions;
    }


    public function setStatus(KernelBootstrapStatus $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): ?KernelBootstrapStatus
    {
        return $this->status;
    }

    public function setCurrent(?string $bootstrapper): void
    {
        $this->currentBootstrapper = $bootstrapper;
    }

    public function getCurrent(): ?string
    {
        return $this->currentBootstrapper;
    }

    /**
     * @param array<int,string> $bootstrappers
     */
    public function setExecuted(array $bootstrappers): void
    {
        $this->executedBootstrappers = $bootstrappers;
    }

    /**
     * @return array<int,string>
     */
    public function getExecuted(): array
    {
        return $this->executedBootstrappers;
    }

    public function setFailed(bool $failed): void
    {
        $this->failed = $failed;
    }

    public function isFailed(): bool
    {
        return $this->failed;
    }

    public function setException(?\Throwable $exception): void
    {
        $this->exception = $exception;
    }

    public function getException(): ?\Throwable
    {
        return $this->exception;
    }
}
