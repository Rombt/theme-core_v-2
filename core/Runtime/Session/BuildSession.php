<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Diagnostics\Diagnostics;
use Rombt\ThemeCore\Infrastructure\Logging\StructuredLogger;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;
use InvalidArgumentException;

final class BuildSession
{
    private string $id;
    private string $state;
    private Diagnostics $diagnostics;
    private LoggerInterface $logger;
    private BuildResources $resources;
    private ?BuildResult $buildResult = null;


    public function __construct(string $id, LoggerInterface $logger)
    {
        $this->id = $id;
        $this->diagnostics = new Diagnostics();
        $this->logger = $logger;
        $this->state = RuntimeState::CREATED;
        $this->resources = new BuildResources();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getResources(): BuildResources
    {
        return $this->resources;
    }

    public function setResource(string $key, mixed $resource): void
    {
        $this->resources->set($key, $resource);
    }

    public function getResource(string $key): mixed
    {
        return $this->resources->get($key);
    }

    public function setBuildResult(BuildResult $buildResult): void
    {
        $this->buildResult = $buildResult;
    }

    public function getBuildResult(): ?BuildResult
    {
        return $this->buildResult;
    }

    public function setState(string $state): void
    {
        if (!RuntimeState::isValid($state)) {
            throw new InvalidArgumentException(
                sprintf('Invalid state: %s', $state)
            );
        }

        $this->state = $state;
    }

    public function getDiagnostics(): Diagnostics
    {
        return $this->diagnostics;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
