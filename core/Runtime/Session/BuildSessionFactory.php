<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;

final class BuildSessionFactory implements BuildSessionFactoryInterface
{
    public function __construct(
        private readonly ArtifactCollectionFactoryInterface $artifactCollections,
    ) {
    }

    public function create(): BuildSession
    {
        return new BuildSession(
            id: uniqid('session_', true),
            resources: new BuildResources(),
            artifacts: $this->artifactCollections->create(),
        );
    }
}
