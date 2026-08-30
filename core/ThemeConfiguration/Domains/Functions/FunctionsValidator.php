<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Functions;

use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;
use RuntimeException;

final readonly class FunctionsValidator implements DomainValidatorInterface
{
    public function validate(ConfigurationDomain $domain): void
    {
        $configuration = $domain->configuration();

        if (!$configuration instanceof FunctionsConfiguration) {
            throw new RuntimeException(
                sprintf(
                    'Expected %s, got %s.',
                    FunctionsConfiguration::class,
                    $configuration::class,
                ),
            );
        }

        $ids = [];

        foreach ($configuration->functions() as $function) {
            $id = $function->id();

            if ($id === '') {
                throw new RuntimeException(
                    'Function definition ID must not be empty.',
                );
            }

            if (isset($ids[$id])) {
                throw new RuntimeException(
                    sprintf(
                        'Duplicate function definition ID "%s".',
                        $id,
                    ),
                );
            }

            $ids[$id] = true;

            if ($function->type() === '') {
                throw new RuntimeException(
                    sprintf(
                        'Function definition "%s" must have a type.',
                        $id,
                    ),
                );
            }

            if ($function->resource() === '') {
                throw new RuntimeException(
                    sprintf(
                        'Function definition "%s" must have a resource.',
                        $id,
                    ),
                );
            }
        }
    }
}
