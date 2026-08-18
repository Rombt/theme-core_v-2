<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents;

use RuntimeException;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\ThemeConfigurationPackage;

final readonly class ThemeComponentBuilderRegistry
{
    /**
     * @param ThemeComponentBuilderInterface[] $builders
     */
    public function __construct(
        private array $builders,
    ) {
    }

    public function builderFor(
        ConfigurationDomain $domain,
    ): ThemeComponentBuilderInterface {
        foreach ($this->builders as $builder) {
            if ($builder->supports($domain)) {
                return $builder;
            }
        }

        throw new RuntimeException(
            sprintf(
                'No ThemeComponentBuilder registered for domain "%s".',
                $domain->id()->value(),
            ),
        );
    }

    /**
     * @return iterable<array{
     *     builder: ThemeComponentBuilderInterface,
     *     domain: ConfigurationDomain
     * }>
     */
    public function buildersFor(
        ThemeConfigurationPackage $package,
    ): iterable {
        foreach ($package->domains()->all() as $domain) {
            yield [
                'builder' => $this->builderFor($domain),
                'domain' => $domain,
            ];
        }
    }
}
