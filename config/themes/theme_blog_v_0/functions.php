<?php

return [

    'setup' => [
        'type' => 'setup',
        'resource' => 'theme_setup',
        'name' => 'Theme Setup',
        'configuration' => [
            'order' => 10,
        ],
    ],

    'image_sizes_01' => [
        'type' => 'hook',
        'resource' => 'image_sizes_01',
        'name' => 'Image Sizes',
        'configuration' => [
            'order' => 20,
        ],
    ],

    'theme_assets_01' => [
        'type' => 'hook',
        'resource' => 'theme_assets_01',
        'name' => 'Theme Assets',
        'configuration' => [
            'order' => 30,
        ],
    ],

    'editor_01' => [
        'type' => 'hook',
        'resource' => 'editor_01',
        'name' => 'Editor Support',
        'configuration' => [
            'order' => 40,
        ],
    ],

    'widgets_01' => [
        'type' => 'hook',
        'resource' => 'widgets_01',
        'name' => 'Widgets',
        'configuration' => [
            'order' => 50,
        ],
    ],

    'theme_hooks_01' => [
        'type' => 'hook',
        'resource' => 'theme_hooks_01',
        'name' => 'Theme Hooks',
        'configuration' => [
            'order' => 60,
        ],
    ],

    'content_filters_01' => [
        'type' => 'hook',
        'resource' => 'content_filters_01',
        'name' => 'Content Filters',
        'configuration' => [
            'order' => 70,
        ],
    ],

    'excerpt_01' => [
        'type' => 'hook',
        'resource' => 'excerpt_01',
        'name' => 'Excerpt',
        'configuration' => [
            'order' => 80,
        ],
    ],

    'body_classes_01' => [
        'type' => 'hook',
        'resource' => 'body_classes_01',
        'name' => 'Body Classes',
        'configuration' => [
            'order' => 90,
        ],
    ],

    'block_styles_01' => [
        'type' => 'hook',
        'resource' => 'block_styles_01',
        'name' => 'Block Styles',
        'configuration' => [
            'order' => 100,
        ],
    ],

    'theme_customizer_01' => [
        'type' => 'customizer',
        'resource' => 'theme_customizer_01',
        'name' => 'Theme Customizer',
        'configuration' => [
            'order' => 110,
        ],
    ],

];
