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
        /** @var array<string, array{
         *     required: bool,
         *     fields: array<string, array{
         *         type: string,
         *         required?: bool,
         *         default?: mixed
         *     }>
         * }> $rules
         */
        $rules = $this->schema->rules();

        foreach ($rules as $section => $rule) {
            $required = $rule['required'];

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

            $sectionConfig = $configuration[$section] ?? [];

            if (!is_array($sectionConfig)) {
                $sectionConfig = [];
            }

            foreach ($rule['fields'] as $field => $fieldRules) {
                $fieldRequired = $fieldRules['required'] ?? false;

                if (
                    $fieldRequired
                    && !array_key_exists($field, $sectionConfig)
                ) {
                    throw new InvalidConfigurationException(
                        sprintf(
                            'Required configuration field [%s.%s] is missing.',
                            $section,
                            $field
                        )
                    );
                }

                if (!array_key_exists($field, $sectionConfig)) {
                    continue;
                }

                $value = $sectionConfig[$field];
                $type = $fieldRules['type'];

                if ($type === 'string' && !is_string($value)) {
                    throw new InvalidConfigurationException(
                        sprintf(
                            'Configuration field [%s.%s] must be string.',
                            $section,
                            $field
                        )
                    );
                }

                if ($type === 'bool' && !is_bool($value)) {
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
