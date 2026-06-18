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
     * @return array<string, mixed>
     */
    public function apply(array $configuration): array
    {
        /**
         * @var array<string, array{
         *     required: bool,
         *     fields: array<string, array{
         *         type: string,
         *         required?: bool,
         *         default?: mixed
         *     }>
         * }> $rules
         */
        $rules = $this->schema->rules();

        foreach ($rules as $section => $sectionRules) {
            if (
                !isset($configuration[$section]) ||
                !is_array($configuration[$section])
            ) {
                $configuration[$section] = [];
            }

            /** @var array<string, mixed> $sectionConfig */
            $sectionConfig = $configuration[$section];

            foreach ($sectionRules['fields'] as $field => $fieldRules) {
                if (array_key_exists($field, $sectionConfig)) {
                    continue;
                }

                if (!array_key_exists('default', $fieldRules)) {
                    continue;
                }

                $sectionConfig[$field] = $fieldRules['default'];
            }

            $configuration[$section] = $sectionConfig;
        }

        return $configuration;
    }
}
