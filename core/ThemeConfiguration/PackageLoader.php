<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainRegistryInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderInterface;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\DomainRegistration;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemePackageInterface;

final class PackageLoader implements PackageLoaderInterface
{
    public function __construct(private readonly DomainRegistryInterface $domains)
    {
    }

    public function load(
        ThemePackageInterface $package,
    ): ThemeConfigurationPackage {
        $domains = $this->loadDomains(
            $package->path(),
            $package->configuration()['domains'] ?? [],
        );

        return new ThemeConfigurationPackage(
            package: $package,
            domains: new DomainCollection($domains),
        );
    }

    /**
     * @param array<string, string> $domains
     *
     * @return iterable<ConfigurationDomain>
     */
    private function loadDomains(
        string $packagePath,
        array $domains,
    ): iterable {
        foreach ($domains as $id => $file) {
            yield $this->loadDomain(
                $id,
                $packagePath . '/' . $file,
            );
        }
    }

    private function loadDomain(
        string $id,
        string $file,
    ): ConfigurationDomain {
        $registration = $this->domains->get(
            new DomainId($id),
        );

        $data = require $file;

        if (!is_array($data)) {
            throw new \RuntimeException(
                sprintf(
                    'Domain "%s" must return array.',
                    $id,
                ),
            );
        }

        return new ConfigurationDomain(
            id: $registration->id(),
            configuration: new ($registration->domainClass())($data),
        );
    }
}
