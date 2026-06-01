<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

final class ConfigurationDefaultsApplier
{
    public function __construct(
        private readonly ConfigurationSchema $schema,
    ) {
    }

    /**
     * @param array<string, mixed> $configuration
     *
     * @return array<string, mixed>
     */
    public function apply(array $configuration): array
    {
        foreach ($this->schema->rules() as $section => $rules) {
            if (!isset($configuration[$section])) {
                $configuration[$section] = [];
            }

            foreach ($rules['fields'] ?? [] as $field => $fieldRules) {
                if (
                    array_key_exists($field, $configuration[$section])
                ) {
                    continue;
                }

                if (!array_key_exists('default', $fieldRules)) {
                    continue;
                }

                $configuration[$section][$field]
                    = $fieldRules['default'];
            }
        }

        return $configuration;
    }
}
