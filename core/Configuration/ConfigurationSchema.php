<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

final class ConfigurationSchema
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'project' => [
                'required' => true,
                'fields'   => [
                    'name' => [
                        'type'     => 'string',
                        'required' => true,
                    ],
                ],
            ],

            'environment' => [
                'required' => true,
                'fields'   => [
                    'debug' => [
                        'type'    => 'bool',
                        'default' => false,
                    ],
                ],
            ],

            'paths' => [
                'required' => true,
                'fields'   => [
                    'build' => [
                        'type'    => 'string',
                        'default' => 'build',
                    ],

                    'cache' => [
                        'type'    => 'string',
                        'default' => '.cache',
                    ],
                ],
            ],

            'logging' => [
                'required' => true,
                'fields'   => [
                    'enabled' => [
                        'type'    => 'bool',
                        'default' => true,
                    ],
                    'path' => [
                        'type'    => 'string',
                        'default' => 'logs/runtime.log',
                    ],
                ],
            ],
        ];
    }
}
