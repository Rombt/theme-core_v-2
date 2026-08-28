<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Providers;

use Rombt\ThemeCore\Composition\Contracts\ServiceDefinitionProviderInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageDiscoveryInterface;
use Rombt\ThemeCore\ThemeConfiguration\FilesystemPackageDiscovery;
use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistryBuilder;
use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistryProvider;
use Rombt\ThemeCore\ThemeIR\ThemeIRBuilder;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIRBuilderInterface;

final class ThemeConfigurationServiceDefinitionProvider implements ServiceDefinitionProviderInterface
{
    public function provide(): array
    {
        return [

            /* Здесь должно быть только то что нужно до начала Pipeline */

            new ServiceDefinition(
                identifier: ThemePackageRegistryProvider::class,
                class: ThemePackageRegistryProvider::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: [
                    PackageDiscoveryInterface::class,
                    ThemePackageRegistryBuilder::class,
                ],
            ),

            new ServiceDefinition(
                identifier: PackageDiscoveryInterface::class,
                class: FilesystemPackageDiscovery::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: [
                ],
            ),

            new ServiceDefinition(
                identifier: ThemePackageRegistryBuilder::class,
                class: ThemePackageRegistryBuilder::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

        ];
    }
}
