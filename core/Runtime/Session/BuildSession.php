<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use Rombt\ThemeCore\Runtime\Result\StageResult;

final class BuildSession
{
    private string $id;

    private string $state;

    private BuildResources $resources;

    private array $stageResults = [];

    public function __construct(string $id)
    {
        $this->id = $id;
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

    public function setState(string $state): void
    {
        if (!RuntimeState::isValid($state)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid runtime state "%s"', $state)
            );
        }

        $this->state = $state;
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

    public function addStageResult(StageResult $result): void
    {
        $this->stageResults[] = $result;
    }

    /**
     * @return StageResult[]
     */
    public function getStageResults(): array
    {
        return $this->stageResults;
    }
}
