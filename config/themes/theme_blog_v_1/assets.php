<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    */

    'styles' => [

        'theme' => [
            'type' => 'style',
            'name' => 'Theme Styles',
            'resource' => [
                'path' => 'assets/css',     //?? как это работает?
                'files' => [
                    'style.css',
                ],
            ],
            'dest_path' => 'assets/css',
            'dependencies' => [],
            'configuration' => [
                'handle' => 'theme-style',
                'enqueue' => true,
                'minify' => true,
            ],
            'function' => [
                'enabled' => true,
                'order' => 30,
            ],
        ],

        'design-system' => [
            'type' => 'style',
            'name' => 'Design system',
            'resource' => [
                'path' => 'assets/css',     //?? как это работает?
                'files' => [
                    'design-system.css',
                ],
            ],
            'dest_path' => 'assets/css',
            'dependencies' => [],
            'configuration' => [
                'handle' => 'design-system',
                'enqueue' => true,
                'minify' => true,
            ],
            'function' => [
                'enabled' => true,
                'order' => 25,
            ],
        ],


    ],


];
