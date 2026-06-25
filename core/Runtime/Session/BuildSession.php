<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use InvalidArgumentException;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Theme\ThemeDefinition;

final class BuildSession
{
    private string $id;
    private string $state;
    private BuildResources $resources;
    private ArtifactCollectionInterface $artifacts;
    private ?BuildResult $buildResult = null;

    public function __construct(
        string $id,
        private readonly ThemeDefinition $theme,
        BuildResources $resources,
        ArtifactCollectionInterface $artifacts
    ) {
        $this->id = $id;
        $this->state = RuntimeState::CREATED;

        $this->resources = $resources;
        $this->artifacts = $artifacts;
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

    public function artifacts(): ArtifactCollectionInterface
    {
        return $this->artifacts;
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

    public function theme(): ThemeDefinition
    {
        return $this->theme;
    }
}
