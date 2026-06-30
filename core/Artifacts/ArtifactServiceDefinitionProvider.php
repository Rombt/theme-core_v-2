<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Providers;

use Rombt\ThemeCore\Artifacts\ArtifactGeneratorRegistry;
use Rombt\ThemeCore\Artifacts\ThemeArtifactGenerator;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;
use Rombt\ThemeCore\Composition\Contracts\ServiceDefinitionProviderInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;

final class ArtifactServiceDefinitionProvider implements ServiceDefinitionProviderInterface
{
    public function provide(): array
    {
        return [
            new ServiceDefinition(
                ArtifactGeneratorRegistry::class,
                ArtifactGeneratorRegistry::class,
                ServiceLifecycle::SINGLETON,
            ),

            new ServiceDefinition(
                ThemeArtifactGeneratorInterface::class,
                ThemeArtifactGenerator::class,
                ServiceLifecycle::LAZY,
                [
                    ArtifactGeneratorRegistry::class,
                ]
            ),
        ];
    }
}
