<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;

final readonly class AssetsValidator implements DomainValidatorInterface
{
    public function validate(ConfigurationDomain $domain): void
    {
        $configuration = $domain->configuration();

        if (!$configuration instanceof AssetsConfiguration) {
            throw new RuntimeException(
                sprintf(
                    'Expected %s, got %s.',
                    AssetsConfiguration::class,
                    $configuration::class,
                ),
            );
        }

        $ids = [];

        foreach ($configuration->assets() as $asset) {
            $id = $asset->id();

            if ($id === '') {
                throw new RuntimeException(
                    'Asset ID must not be empty.',
                );
            }

            if (isset($ids[$id])) {
                throw new RuntimeException(
                    sprintf(
                        'Duplicate asset ID "%s".',
                        $id,
                    ),
                );
            }

            $ids[$id] = true;

            if ($asset->destPath() === '') {
                throw new RuntimeException(
                    sprintf(
                        'Asset "%s" must have a destination path.',
                        $id,
                    ),
                );
            }

            if ($asset->resource()->path() === '') {
                throw new RuntimeException(
                    sprintf(
                        'Asset "%s" must have a resource path.',
                        $id,
                    ),
                );
            }

            foreach ($asset->dependencies() as $dependency) {
                if ($dependency === '') {
                    throw new RuntimeException(
                        sprintf(
                            'Asset "%s" contains an empty dependency.',
                            $id,
                        ),
                    );
                }
            }
        }
    }
}
