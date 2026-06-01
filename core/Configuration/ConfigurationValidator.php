<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

use Rombt\ThemeCore\Configuration\Exception\InvalidConfigurationException;

final class ConfigurationValidator
{
    public function __construct(
        private readonly ConfigurationSchema $schema,
    ) {
    }

/**
 * @param array<string, mixed> $configuration
 */
    public function validate(array $configuration): void
    {
        foreach ($this->schema->rules() as $section => $rules) {
            $required = $rules['required'] ?? false;

            if (
                $required
                && !array_key_exists($section, $configuration)
            ) {
                throw new InvalidConfigurationException(
                    sprintf(
                        'Required configuration section [%s] is missing.',
                        $section
                    )
                );
            }

            if (!isset($configuration[$section])) {
                continue;
            }

            foreach ($rules['fields'] ?? [] as $field => $fieldRules) {
                $fieldRequired = $fieldRules['required'] ?? false;

                if (
                    $fieldRequired
                    && !array_key_exists($field, $configuration[$section])
                ) {
                    throw new InvalidConfigurationException(
                        sprintf(
                            'Required configuration field [%s.%s] is missing.',
                            $section,
                            $field
                        )
                    );
                }

                if (!array_key_exists($field, $configuration[$section])) {
                    continue;
                }

                $value = $configuration[$section][$field];

                $type = $fieldRules['type'] ?? null;

                if (
                    $type === 'string'
                    && !is_string($value)
                ) {
                    throw new InvalidConfigurationException(
                        sprintf(
                            'Configuration field [%s.%s] must be string.',
                            $section,
                            $field
                        )
                    );
                }

                if (
                    $type === 'bool'
                    && !is_bool($value)
                ) {
                    throw new InvalidConfigurationException(
                        sprintf(
                            'Configuration field [%s.%s] must be bool.',
                            $section,
                            $field
                        )
                    );
                }
            }
        }
    }
}
