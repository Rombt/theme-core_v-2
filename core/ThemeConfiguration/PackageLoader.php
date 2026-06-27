<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainRegistryInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderInterface;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistration;

final class PackageLoader implements PackageLoaderInterface
{
    public function __construct(
        private readonly DomainRegistryInterface $domains,
    ) {
    }

    public function load(
        ThemePackageRegistration $registration,
    ): ThemeConfigurationPackage {
        $domains = $this->loadDomains(
            $registration->path(),
        );

        return new ThemeConfigurationPackage(
            id: $registration->id(),
            metadata: $registration->metadata(),
            domains: new DomainCollection($domains),
        );
    }

    /**
     * @return iterable<ConfigurationDomain>
     */
    private function loadDomains(
        string $packagePath,
    ): iterable {
        foreach ($this->domains->all() as $registration) {
            yield $this->loadDomain(
                $packagePath,
                $registration,
            );
        }
    }

    private function loadDomain(string $packagePath, DomainRegistration $registration): ConfigurationDomain
    {
        $file = sprintf(
            '%s/%s.php',
            $packagePath,
            $registration->id()->value(),
        );

        if (!is_file($file)) {
            throw new \RuntimeException(
                sprintf(
                    'Domain configuration "%s" not found.',
                    $file,
                ),
            );
        }

        $data = require $file;

        if (!is_array($data)) {
            throw new \RuntimeException(
                sprintf(
                    'Domain "%s" must return array.',
                    $registration->id()->value(),
                ),
            );
        }

        $configuration = new ($registration->domainClass())($data);

        return new ConfigurationDomain(
            id: $registration->id(),
            configuration: $configuration,
        );
    }
}
