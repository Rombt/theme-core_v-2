<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemeDefinitionProviderInterface;

final class BuildSessionFactory implements BuildSessionFactoryInterface
{
    public function __construct(
        private readonly ArtifactCollectionFactoryInterface $artifactCollections,
        private readonly ThemeDefinitionProviderInterface $themeProvider,
    ) {
    }

    public function create(): BuildSession
    {
        return new BuildSession(
            id: uniqid('session_', true),
            theme: $this->themeProvider->provide(),
            resources: new BuildResources(),
            artifacts: $this->artifactCollections->create(),
        );
    }
}
