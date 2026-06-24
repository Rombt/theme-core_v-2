<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\Theme\ThemeDefinition;
use Rombt\ThemeCore\Theme\Contracts\ThemeDefinitionBuilderInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderServiceInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageSelectorInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageValidatorInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemeDefinitionProviderInterface;
use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;

final readonly class ThemeDefinitionProvider implements ThemeDefinitionProviderInterface
{
    public function __construct(
        private readonly ConfigurationInterface $configuration,
        private readonly PackageSelectorInterface $selector,
        private readonly PackageLoaderServiceInterface $loader,
        private readonly PackageValidatorInterface $validator,
        private readonly ThemeDefinitionBuilderInterface $builder,
    ) {
    }

    public function provide(): ThemeDefinition
    {
        $packageId = new PackageId((string) $this->configuration->get('theme.package',));

        $selected = $this->selector->select($packageId,);

        $loaded = $this->loader->load($selected,);

        $this->validator->validate($loaded,);

        return $this->builder->build(new ValidatedPackage($loaded->package()));
    }
}
