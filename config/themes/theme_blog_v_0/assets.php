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
                'path' => 'assets/style/theme',
                'files' => [
                    'style.css',
                ],
            ],
            'dest_path' => 'assets/css/style.css',
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
                'path' => 'assets/style/editor',
                'files' => [
                    'editor.css',
                ],
            ],
            'dest_path' => 'assets/css/editor.css',
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
                'path' => 'assets/style/elementor',
                'files' => [
                    'elementor.css',
                ],
            ],
            'dest_path' => 'assets/css/elementor.css',
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
                'path' => 'assets/script/theme',
                'files' => [
                    'theme.js',
                ],
            ],
            'dest_path' => 'assets/js/theme.js',
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
                'path' => 'assets/script/navigation',
                'files' => [
                    'navigation.js',
                ],
            ],
            'dest_path' => 'assets/js/navigation.js',
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
                'path' => 'assets/script/editor',
                'files' => [
                    'editor.js',
                ],
            ],
            'dest_path' => 'assets/js/editor.js',
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
                'path' => 'assets/script/elementor',
                'files' => [
                    'elementor.js',
                ],
            ],
            'dest_path' => 'assets/js/elementor.js',
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
                'path' => 'assets/font/primary',
                'files' => [
                    'Audiowide-Regular.ttf',
                ],
            ],
            'dest_path' => 'assets/fonts/Audiowide-Regular.ttf',
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
                'path' => 'assets/font/primary-bold',
                'files' => [
                    'DynaPuff-VariableFont_wdth,wght.ttf',
                ],
            ],
            'dest_path' => 'assets/fonts/DynaPuff-VariableFont_wdth,wght.ttf',
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
                'path' => 'assets/image/logo',
                'files' => [
                    'logo.svg',
                ],
            ],
            'dest_path' => 'assets/images/logo.svg',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'logo',
            ],
        ],

        'logo-light' => [
            'type' => 'image',
            'name' => 'Light Logo',
            'resource' => [
                'path' => 'assets/image/logo-light',
                'files' => [
                    'logo-light.svg',
                ],
            ],
            'dest_path' => 'assets/images/logo-light.svg',
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
                'path' => 'assets/image/favicon',
                'files' => [
                    'favicon.ico',
                ],
            ],
            'dest_path' => 'favicon.ico',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'favicon',
            ],
        ],

        'site-icon' => [
            'type' => 'image',
            'name' => 'Site Icon',
            'resource' => [
                'path' => 'assets/image/site-icon',
                'files' => [
                    'site-icon.png',
                ],
            ],
            'dest_path' => 'assets/images/site-icon.png',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'site-icon',
            ],
        ],

        'theme-preview' => [
            'type' => 'image',
            'name' => 'Theme Preview',
            'resource' => [
                'path' => 'assets/image/theme-preview',
                'files' => [
                    'screenshot.png',
                ],
            ],
            'dest_path' => 'screenshot.png',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'theme-preview',
            ],
        ],

        'icon' => [
            'type' => 'image',
            'name' => 'Theme Icon',
            'resource' => [
                'path' => 'assets/image/icon',
                'files' => [
                    'icon.svg',
                ],
            ],
            'dest_path' => 'assets/images/icon.svg',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'icon',
            ],
        ],

        'background' => [
            'type' => 'image',
            'name' => 'Background Image',
            'resource' => [
                'path' => 'assets/image/background',
                'files' => [
                    [
                        'path' => 'background.webp',
                        'dest_path' => 'assets/images/background.webp',
                    ],
                    [
                        'path' => 'background.jpeg',
                        'dest_path' => 'assets/images/background.jpeg',
                    ],
                ],
            ],
            'dest_path' => '',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'background',
            ],
        ],

        'demo' => [
            'type' => 'image',
            'name' => 'Demo Images',
            'resource' => [
                'path' => 'assets/image/demo',
                'files' => [
                    [
                        'path' => 'hero.avif',
                        'dest_path' => 'assets/images/demo/hero.avif',
                    ],
                    [
                        'path' => 'hero.jpg',
                        'dest_path' => 'assets/images/demo/hero.jpg',
                    ],
                    [
                        'path' => 'about.jpg',
                        'dest_path' => 'assets/images/demo/about.jpg',
                    ],
                    [
                        'path' => 'post.webp',
                        'dest_path' => 'assets/images/demo/post.webp',
                    ],
                    [
                        'path' => 'post.jpg',
                        'dest_path' => 'assets/images/demo/post.jpg',
                    ],
                ],
            ],
            'dest_path' => '',
            'dependencies' => [],
            'configuration' => [
                'usage' => 'demo-content',
            ],
        ],

    ],

];
