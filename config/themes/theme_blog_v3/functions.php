<?php

return [

    'setup' => [
        'type' => 'setup',
        'resource' => 'theme_setup',
        'name' => 'Theme Setup',
        'configuration' => [
            'order' => 20,
        ],


        'supports' => [
            'title-tag',
            'post-thumbnails',
            'custom-logo',
            'custom-background',
            'custom-header',
            'automatic-feed-links',
            'html5',
            'post-formats',
        ],

        'image_sizes' => [
            [
                'name' => 'featured-large',
                'width' => 1200,
                'height' => 800,
                'crop' => true,
            ],
            [
                'name' => 'featured-medium',
                'width' => 800,
                'height' => 533,
                'crop' => true,
            ],
            [
                'name' => 'featured-small',
                'width' => 400,
                'height' => 267,
                'crop' => true,
            ],
        ],

        'textdomain' => 'blog-theme',

        'content_width' => 1200,
    ],

    'theme_hooks_01' => [
        'type' => 'hook',
        'resource' => 'theme_hooks_01',
        'name' => 'Theme Hooks',
        'configuration' => [
            'order' => 25,
        ],
    ],

    'theme_customizer_01' => [
        'type' => 'customizer',
        'resource' => 'theme_customizer_01',
        'name' => 'Theme Customizer',
        'configuration' => [
            'order' => 70,
        ],
    ],

];
