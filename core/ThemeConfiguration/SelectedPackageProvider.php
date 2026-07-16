<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageSelectorInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\SelectedPackageProviderInterface;

final readonly class SelectedPackageProvider implements SelectedPackageProviderInterface
{
    public function __construct(
        private ConfigurationInterface $configuration,
        private PackageSelectorInterface $selector,
        private PackageLoaderInterface $loader,
    ) {
    }

    public function provide(): ThemeConfigurationPackage
    {
        $packageId = new PackageId(
            (string) $this->configuration->get('theme.package'),
        );

        $selected = $this->selector->select($packageId);

        return $this->loader->load($selected->registration());
    }
}
