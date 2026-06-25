<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\Theme\ThemeDefinition;

final class BuildSessionFactory implements BuildSessionFactoryInterface
{
    public function __construct(
        private readonly ArtifactCollectionFactoryInterface $artifactCollections,
    ) {
    }

    public function create(ThemeDefinition $theme): BuildSession
    {
        return new BuildSession(
            id: uniqid('session_', true),
            theme: $theme,
            resources: new BuildResources(),
            artifacts: $this->artifactCollections->create(),
        );
    }
}
