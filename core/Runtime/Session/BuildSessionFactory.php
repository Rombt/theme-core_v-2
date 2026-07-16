<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

final class BuildSessionFactory implements BuildSessionFactoryInterface
{
    public function __construct(
        private readonly ArtifactCollectionFactoryInterface $artifactCollections,
    ) {
    }

    public function create(
        ThemeConfigurationPackage $package,
    ): BuildSession {
        return new BuildSession(
            id: uniqid('session_', true),
            package: $package,
            resources: new BuildResources(),
            artifacts: $this->artifactCollections->create(),
        );
    }
}
