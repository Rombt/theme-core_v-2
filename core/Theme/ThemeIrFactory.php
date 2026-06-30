<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\DomainId;
use Rombt\ThemeCore\ThemeConfiguration\ValidatedPackage;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final class ThemeIrFactory
{
    public function create(
        ValidatedPackage $package,
    ): ThemeIr {
        $domains = $package->package()->domains();


        return new ThemeIr(
            entities: $this->load($domains, 'entities'),
            compositions: $this->load($domains, 'compositions'),
            queries: $this->load($domains, 'queries'),
            workflows: $this->load($domains, 'workflows'),
            designSystems: $this->load($domains, 'design-systems'),
            assets: $this->load($domains, 'assets'),
            integrations: $this->load($domains, 'integrations'),
        );
    }

    private function load($domains, string $id): array
    {
        $domainId = new DomainId($id);

        if (!$domains->has($domainId)) {
            return [];
        }

        $configuration = $domains
        ->get($domainId)
        ->configuration();

        if (!$configuration instanceof IrExportableInterface) {
            throw new RuntimeException(
                sprintf(
                    'Domain "%s" is not exportable to IR.',
                    $id,
                )
            );
        }

        return $configuration->toArray();
    }
}
