<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainProviderInterface;

final readonly class PackageDomainProvider implements DomainProviderInterface
{
    public function __construct(
        private ThemeConfigurationPackage $package,
    ) {
    }

    public function has(
        DomainId $id,
    ): bool {
        return $this->package
            ->domains()
            ->has($id);
    }

    public function get(
        DomainId $id,
    ): ConfigurationDomainInterface {
        $domain = $this->package
            ->domains()
            ->get($id);

        $configuration = $domain->configuration();

        if (!$configuration instanceof ConfigurationDomainInterface) {
            throw new RuntimeException(
                sprintf(
                    'Domain "%s" has invalid configuration.',
                    $id->value(),
                ),
            );
        }

        return $configuration;
    }
}
