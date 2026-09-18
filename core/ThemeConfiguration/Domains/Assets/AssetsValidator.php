<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;

final readonly class AssetsValidator implements DomainValidatorInterface
{
    private const int MIN_FUNCTION_ORDER = 0;
    private const int MAX_FUNCTION_ORDER = 100;

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

            if ($asset->type() === '') {
                throw new RuntimeException(
                    sprintf(
                        'Asset "%s" must have a type.',
                        $id,
                    ),
                );
            }

            if ($asset->entry() === '') {
                throw new RuntimeException(
                    sprintf(
                        'Asset "%s" must have an entry.',
                        $id,
                    ),
                );
            }

            foreach ($asset->dependencies() as $dependency) {
                if ($dependency === '') {
                    throw new RuntimeException(
                        sprintf(
                            'Dependency for asset "%s" must not be empty.',
                            $id,
                        ),
                    );
                }
            }

            $function = $asset->function();

            if ($function === null) {
                continue;
            }

            $order = $function->order();

            if (
                $order < self::MIN_FUNCTION_ORDER
                || $order > self::MAX_FUNCTION_ORDER
            ) {
                throw new RuntimeException(
                    sprintf(
                        'Function order for asset "%s" must be between %d and %d.',
                        $id,
                        self::MIN_FUNCTION_ORDER,
                        self::MAX_FUNCTION_ORDER,
                    ),
                );
            }
        }
    }
}
