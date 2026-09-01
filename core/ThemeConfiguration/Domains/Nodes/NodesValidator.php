<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Definitions\FunctionDefinition;
use RuntimeException;

final readonly class NodesValidator implements DomainValidatorInterface
{
    private const int MIN_FUNCTION_ORDER = 0;
    private const int MAX_FUNCTION_ORDER = 100;

    public function validate(ConfigurationDomain $domain): void
    {
        $configuration = $domain->configuration();

        if (!$configuration instanceof NodesConfiguration) {
            throw new RuntimeException(
                sprintf(
                    'Expected %s, got %s.',
                    NodesConfiguration::class,
                    $configuration::class,
                ),
            );
        }

        $ids = [];

        foreach ($configuration->nodes() as $node) {
            $id = $node->id();

            if ($id === '') {
                throw new RuntimeException(
                    'Node ID must not be empty.',
                );
            }

            if (isset($ids[$id])) {
                throw new RuntimeException(
                    sprintf(
                        'Duplicate node ID "%s".',
                        $id,
                    ),
                );
            }

            $ids[$id] = true;

            $function = $node->function();

            if (!$function instanceof FunctionDefinition) {
                continue;
            }

            $order = $function->order();

            if (
                $order < self::MIN_FUNCTION_ORDER
                || $order > self::MAX_FUNCTION_ORDER
            ) {
                throw new RuntimeException(
                    sprintf(
                        'Function order for node "%s" must be between %d and %d.',
                        $id,
                        self::MIN_FUNCTION_ORDER,
                        self::MAX_FUNCTION_ORDER,
                    ),
                );
            }
        }
    }
}
