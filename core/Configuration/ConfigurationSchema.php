<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

/**
 * @phpstan-type FieldSchema array{
 *     type: string,
 *     required?: bool,
 *     default?: mixed
 * }
 *
 * @phpstan-type SectionSchema array{
 *     required: bool,
 *     fields: array<string, FieldSchema>
 * }
 *
 * @phpstan-type Schema array<string, SectionSchema>
 */
final class ConfigurationSchema
{
    /**
     * @return Schema
     */
    public function rules(): array
    {
        return [
            'project' => [
                'required' => true,
                'fields' => [
                    'name' => [
                        'type' => 'string',
                        'required' => true,
                    ],
                ],
            ],

            'theme' => [
                'required' => true,
                'fields' => [
                    'packages_path' => [
                        'type' => 'string',
                        'required' => true,
                    ],
                    'package' => [
                        'type' => 'string',
                        'required' => true,
                    ],
                    'resource_package' => [
                        'type' => 'string',
                        'required' => true,
                        'default' => 'resources',
                    ],
                ],
            ],

            'environment' => [
                'required' => true,
                'fields' => [
                    'debug' => [
                        'type' => 'bool',
                        'default' => false,
                    ],
                ],
            ],

            'paths' => [
                'required' => true,
                'fields' => [
                'output' => [
                    'type' => 'output',
                    'default' => [
                        'relative' => 'build',
                        ],
                ],
                'bases' => [
                    'type' => 'array',
                    'default' => [],
                ],
                'cache' => [
                    'type' => 'string',
                    'default' => '.cache',
                ],
                ],
            ],

            'php_parser' => [
                'required' => true,
                'fields' => [
                    'format' => [
                        'type' => 'string',
                        'default' => 'pretty_print',
                    ],
                ],
            ],

            'logging' => [
                'required' => true,
                'fields' => [
                    'enabled' => [
                        'type' => 'bool',
                        'default' => true,
                    ],
                    'path' => [
                        'type' => 'string',
                        'default' => 'logs/runtime.log',
                    ],
                ],
            ],

            'diagnostic' => [
                'required' => true,
                'fields' => [
                    'enabled' => [
                        'type' => 'bool',
                        'default' => true,
                    ],
                    'path' => [
                        'type' => 'string',
                        'default' => 'logs/diagnostic.log',
                    ],
                ],
            ],
        ];
    }
}
