<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Providers;

use Rombt\ThemeCore\Composition\Contracts\ServiceDefinitionProviderInterface;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\Theme\Contracts\ThemeDefinitionBuilderInterface;
use Rombt\ThemeCore\Theme\ThemeDefinitionBuilder;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderServiceInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageSelectorInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageValidatorInterface;
use Rombt\ThemeCore\ThemeConfiguration\PackageLoaderService;
use Rombt\ThemeCore\ThemeConfiguration\RegistryPackageSelector;
use Rombt\ThemeCore\ThemeConfiguration\ThemeDefinitionProvider;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageDiscoveryInterface;
use Rombt\ThemeCore\ThemeConfiguration\FilesystemPackageDiscovery;
use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistryBuilder;
use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistryProvider;
use Rombt\ThemeCore\ThemeConfiguration\PackageValidator;
use Rombt\ThemeCore\Theme\ThemeMetadataFactory;
use Rombt\ThemeCore\Theme\ThemeComponentBuilderRegistry;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageRegistryInterface;
use Rombt\ThemeCore\ThemeConfiguration\ThemePackageRegistry;
use Rombt\ThemeCore\Theme\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesComponentBuilder;

final class ThemeConfigurationServiceDefinitionProvider implements ServiceDefinitionProviderInterface
{
    public function provide(): array
    {
        return [

            new ServiceDefinition(
                identifier: PackageSelectorInterface::class,
                class: RegistryPackageSelector::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: [
                    PackageRegistryInterface::class,
                ],
            ),

            new ServiceDefinition(
                identifier: PackageRegistryInterface::class,
                class: ThemePackageRegistry::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: [
                ],
            ),

            new ServiceDefinition(
                identifier: PackageLoaderServiceInterface::class,
                class: PackageLoaderService::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

            new ServiceDefinition(
                identifier: PackageValidatorInterface::class,
                class: PackageValidator::class,
                lifecycle: ServiceLifecycle::LAZY,
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
                identifier: ThemeMetadataFactory::class,
                class: ThemeMetadataFactory::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

            new ServiceDefinition(
                identifier: TemplatesComponentBuilder::class,
                class: TemplatesComponentBuilder::class,
                lifecycle: ServiceLifecycle::LAZY,
            ),

        ];
    }
}
