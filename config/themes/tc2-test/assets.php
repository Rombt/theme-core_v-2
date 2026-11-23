<?php

declare(strict_types=1);

return [
    'styles' => [
        'theme-fonts' => [
            'type' => 'style',
            'name' => 'Theme Fonts',
            'resource' => [
                'path' => 'assets/style/fonts',
                'files' => ['fonts.css'],
            ],
            'dest_path' => 'assets/style/fonts.css',
            'dependencies' => [],
            'function' => ['enabled' => true, 'order' => 25],
        ],
        'theme-style' => [
            'type' => 'style',
            'name' => 'Theme Styles',
            'resource' => [
                'path' => 'assets/style/index',
                'files' => ['main-style.css'],
            ],
            'dest_path' => 'assets/style/main-style.css',
            'dependencies' => ['theme-fonts'],
            'function' => ['enabled' => true, 'order' => 30],
        ],
    ],
    'scripts' => [
        'theme-script' => [
            'type' => 'script',
            'name' => 'Theme Script',
            'resource' => [
                'path' => 'assets/script/index',
                'files' => ['main-scripts.js'],
            ],
            'dest_path' => 'assets/js/main-scripts.js',
            'dependencies' => [],
            'function' => ['enabled' => true, 'order' => 40],
        ],
    ],
    'fonts' => [
        'space-grotesk' => [
            'type' => 'font',
            'name' => 'Space Grotesk',
            'resource' => [
                'path' => 'assets/font/index',
                'files' => [
                    ['path' => 'SpaceGrotesk-Light.ttf', 'dest_path' => 'assets/fonts/SpaceGrotesk-Light.ttf'],
                    ['path' => 'SpaceGrotesk-Regular.ttf', 'dest_path' => 'assets/fonts/SpaceGrotesk-Regular.ttf'],
                    ['path' => 'SpaceGrotesk-Medium.ttf', 'dest_path' => 'assets/fonts/SpaceGrotesk-Medium.ttf'],
                    ['path' => 'SpaceGrotesk-SemiBold.ttf', 'dest_path' => 'assets/fonts/SpaceGrotesk-SemiBold.ttf'],
                    ['path' => 'SpaceGrotesk-Bold.ttf', 'dest_path' => 'assets/fonts/SpaceGrotesk-Bold.ttf'],
                    ['path' => 'SpaceGrotesk-VariableFont_wght.ttf', 'dest_path' => 'assets/fonts/SpaceGrotesk-VariableFont_wght.ttf'],
                ],
            ],
            'dependencies' => [],
            'configuration' => [],
        ],
    ],
    'images' => [
        'theme-images' => [
            'type' => 'image',
            'name' => 'Theme Images',
            'resource' => [
                'path' => 'assets/image/index',
                'files' => [
                    ['path' => 'test_1.jpg', 'dest_path' => 'assets/images/test_1.jpg'],
                    ['path' => 'test_2.jpg', 'dest_path' => 'assets/images/test_2.jpg'],
                    ['path' => 'icons/sprite.svg', 'dest_path' => 'assets/images/icons/sprite.svg'],
                ],
            ],
            'dependencies' => [],
            'configuration' => [],
        ],
    ],
];
