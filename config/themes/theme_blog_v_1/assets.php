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
                'path' => 'assets/css',
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


    ],


];
