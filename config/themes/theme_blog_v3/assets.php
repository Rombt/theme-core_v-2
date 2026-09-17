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

        'editor' => [
            'type' => 'style',
            'name' => 'Editor Styles',
            'resource' => [
                'path' => 'assets/css',
                'files' => [
                    'editor.css',
                ],
            ],
            'dest_path' => 'assets/css',
            'dependencies' => [
                'theme',
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

        'elementor' => [
            'type' => 'style',
            'name' => 'Elementor Styles',
            'resource' => [
                'path' => 'assets/css',
                'files' => [
                    'elementor.css',
                ],
            ],
            'dest_path' => 'assets/css',
            'dependencies' => [
                'theme',
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

        'theme' => [
            'type' => 'script',
            'name' => 'Theme Script',
            'resource' => [
                'path' => 'assets/js',
                'files' => [
                    'theme.js',
                ],
            ],
            'dest_path' => 'assets/js',
            'dependencies' => [],
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

        'navigation' => [
            'type' => 'script',
            'name' => 'Navigation Script',
            'resource' => [
                'path' => 'assets/js',
                'files' => [
                    'navigation.js',
                ],
            ],
            'dest_path' => 'assets/js',
            'dependencies' => [
                'theme',
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

        'editor' => [
            'type' => 'script',
            'name' => 'Editor Script',
            'resource' => [
                'path' => 'assets/js',
                'files' => [
                    'editor.js',
                ],
            ],
            'dest_path' => 'assets/js',
            'dependencies' => [
                'theme',
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

        'elementor' => [
            'type' => 'script',
            'name' => 'Elementor Script',
            'resource' => [
                'path' => 'assets/js',
                'files' => [
                    'elementor.js',
                ],
            ],
            'dest_path' => 'assets/js',
            'dependencies' => [
                'theme',
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

        'primary' => [
            'type' => 'font',
            'name' => 'Primary Font',
            'resource' => [
                'path' => 'assets/fonts',
                'files' => [
                    'Audiowide-Regular.ttf',
                ],
            ],
            'dest_path' => 'assets/fonts',
            'dependencies' => [],
            'configuration' => [
                'family' => 'Theme Primary',
                'weight' => '400',
                'style' => 'normal',
            ],
        ],

        'primary-bold' => [
            'type' => 'font',
            'name' => 'Primary Bold Font',
            'resource' => [
                'path' => 'assets/fonts',
                'files' => [
                    'DynaPuff-VariableFont_wdth,wght.ttf',
                ],
            ],
            'dest_path' => 'assets/fonts',
            'dependencies' => [
                'primary',
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

        'logo' => [
            'type' => 'image',
            'name' => 'Logo',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'logo.svg',
                ],
            ],
            'dest_path' => 'assets/images',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'logo',
            ],
        ],

        'logo-light' => [
            'type' => 'image',
            'name' => 'Light Logo',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'logo-light.svg',
                ],
            ],
            'dest_path' => 'assets/images',
            'dependencies' => [
                'logo',
            ],
            'configuration' => [
                'usage' => 'logo',
                'variant' => 'light',
            ],
        ],

        'favicon' => [
            'type' => 'image',
            'name' => 'Favicon',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'favicon.ico',
                ],
            ],
            'dest_path' => '',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'favicon',
            ],
        ],

        'site-icon' => [
            'type' => 'image',
            'name' => 'Site Icon',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'site-icon.png',
                ],
            ],
            'dest_path' => 'assets/images',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'site-icon',
            ],
        ],

        'theme-preview' => [
            'type' => 'image',
            'name' => 'Theme Preview',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'screenshot.png',
                ],
            ],
            'dest_path' => '',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'theme-preview',
            ],
        ],

        'icon' => [
            'type' => 'image',
            'name' => 'Theme Icon',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'icon.svg',
                ],
            ],
            'dest_path' => 'assets/images',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'icon',
            ],
        ],

        'background' => [
            'type' => 'image',
            'name' => 'Background Image',
            'resource' => [
                'path' => 'assets/images',
                'files' => [
                    'background.webp',
                    'background.jpeg',
                ],
            ],
            'dest_path' => 'assets/images',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'background',
            ],
        ],

        'demo' => [
            'type' => 'image',
            'name' => 'Demo Images',
            'resource' => [
                'path' => 'assets/images/demo',
                'files' => [
                    'hero.avif',
                    'hero.jpg',
                    'about.jpg',
                    'post.webp',
                    'post.jpg',
                ],
            ],
            'dest_path' => 'assets/images/demo',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'demo-content',
            ],
        ],

    ],

];
