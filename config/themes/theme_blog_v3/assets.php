<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    */

    'styles' => [

        [
            'id' => 'theme',
            'type' => 'style',
            'resource' => [
                'path' => 'assets/css',
                'files' => [
                    'style.css',
                ],
            ],
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

        [
            'id' => 'editor',
            'type' => 'style',
            'resource' => [
                'path' => 'assets/css',
                'files' => [
                    'editor.css',
                ],
            ],
            'configuration' => [
                'handle' => 'theme-editor',
                'enqueue' => true,
                'context' => 'editor',
                'minify' => true,
            ],
            'function' => [
                'enabled' => true,
                'order' => 30,
            ],
        ],

        [
            'id' => 'elementor',
            'type' => 'style',
            'resource' => [
                'path' => 'assets/css',
                'files' => [
                    'elementor.css',
                ],
            ],
            'configuration' => [
                'handle' => 'theme-elementor',
                'enqueue' => true,
                'context' => 'elementor',
                'minify' => true,
            ],
            'function' => [
                'enabled' => true,
                'order' => 30,
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Scripts
    |--------------------------------------------------------------------------
    */

    'scripts' => [

        [
            'id' => 'theme',
            'type' => 'script',
            'resource' => [
                'path' => 'assets/js',
                'files' => [
                    'theme.js',
                ],
            ],
            'configuration' => [
                'handle' => 'theme-script',
                'enqueue' => true,
                'in_footer' => true,
                'minify' => true,
            ],
            'function' => [
                'enabled' => true,
                'order' => 40,
            ],
        ],

        [
            'id' => 'navigation',
            'type' => 'script',
            'resource' => [
                'path' => 'assets/js',
                'files' => [
                    'navigation.js',
                ],
            ],
            'configuration' => [
                'handle' => 'theme-navigation',
                'enqueue' => true,
                'in_footer' => true,
                'minify' => true,
            ],
            'function' => [
                'enabled' => true,
                'order' => 40,
            ],
        ],

        [
            'id' => 'editor',
            'type' => 'script',
            'resource' => [
                'path' => 'assets/js',
                'files' => [
                    'editor.js',
                ],
            ],
            'configuration' => [
                'handle' => 'theme-editor',
                'enqueue' => true,
                'context' => 'editor',
                'in_footer' => true,
                'minify' => true,
            ],
            'function' => [
                'enabled' => true,
                'order' => 40,
            ],
        ],

        [
            'id' => 'elementor',
            'type' => 'script',
            'resource' => [
                'path' => 'assets/js',
                'files' => [
                    'elementor.js',
                ],
            ],
            'configuration' => [
                'handle' => 'theme-elementor',
                'enqueue' => true,
                'context' => 'elementor',
                'in_footer' => true,
                'minify' => true,
            ],
            'function' => [
                'enabled' => true,
                'order' => 50,
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Fonts
    |--------------------------------------------------------------------------
    */

    'fonts' => [

        [
            'id' => 'primary',
            'type' => 'font',
            'resource' => [
                'path' => 'assets/fonts',
                'files' => [
                    'primary.woff2',
                    'primary.woff',
                ],
            ],
            'configuration' => [
                'family' => 'Theme Primary',
                'weight' => '400',
                'style' => 'normal',
            ],
        ],

        [
            'id' => 'primary-bold',
            'type' => 'font',
            'resource' => [
                'path' => 'assets/fonts',
                'files' => [
                    'primary-bold.woff2',
                    'primary-bold.woff',
                ],
            ],
            'configuration' => [
                'family' => 'Theme Primary',
                'weight' => '700',
                'style' => 'normal',
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    */

    'images' => [

        [
            'id' => 'logo',
            'type' => 'image',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'logo.svg',
                ],
            ],
            'configuration' => [
                'usage' => 'logo',
            ],
        ],

        [
            'id' => 'logo-light',
            'type' => 'image',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'logo-light.svg',
                ],
            ],
            'configuration' => [
                'usage' => 'logo',
                'variant' => 'light',
            ],
        ],

        [
            'id' => 'favicon',
            'type' => 'image',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'favicon.ico',
                ],
            ],
            'configuration' => [
                'usage' => 'favicon',
            ],
        ],

        [
            'id' => 'site-icon',
            'type' => 'image',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'site-icon.png',
                ],
            ],
            'configuration' => [
                'usage' => 'site-icon',
            ],
        ],

        [
            'id' => 'theme-preview',
            'type' => 'image',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'screenshot.png',
                ],
            ],
            'configuration' => [
                'usage' => 'theme-preview',
            ],
        ],

        [
            'id' => 'icon',
            'type' => 'image',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'icon.svg',
                ],
            ],
            'configuration' => [
                'usage' => 'icon',
            ],
        ],

        [
            'id' => 'background',
            'type' => 'image',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'background.jpg',
                ],
            ],
            'configuration' => [
                'usage' => 'background',
            ],
        ],

        [
            'id' => 'demo',
            'type' => 'image',
            'resource' => [
                'path' => 'assets/images/demo',
                'files' => [
                    'hero.jpg',
                    'about.jpg',
                    'post.jpg',
                ],
            ],
            'configuration' => [
                'usage' => 'demo-content',
            ],
        ],

    ],

];
