<?php

return [

    'setup' => [
        'type' => 'setup',
        'resource' => 'theme_setup',
        'name' => 'Theme Setup',

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

    'primary_sidebar_01' => [
        'type' => 'sidebar',
        'resource' => 'primary_sidebar_01',
        'name' => 'Primary Sidebar',

        'sidebar' => [
            'id' => 'primary-sidebar',
            'name' => 'Primary Sidebar',
            'description' => 'Main sidebar displayed on posts and pages.',
        ],
    ],

    'footer_sidebar_01' => [
        'type' => 'sidebar',
        'resource' => 'footer_sidebar_01',
        'name' => 'Footer Sidebar',

        'sidebar' => [
            'id' => 'footer-sidebar',
            'name' => 'Footer Sidebar',
            'description' => 'Footer widget area.',
        ],
    ],

    'primary_navigation_01' => [
        'type' => 'navigation',
        'resource' => 'primary_navigation_01',
        'name' => 'Primary Navigation',

        'menu' => [
            'location' => 'primary',
            'label' => 'Primary Menu',
        ],
    ],

    'footer_navigation_01' => [
        'type' => 'navigation',
        'resource' => 'footer_navigation_01',
        'name' => 'Footer Navigation',

        'menu' => [
            'location' => 'footer',
            'label' => 'Footer Menu',
        ],
    ],

    'theme_hooks_01' => [
        'type' => 'hook',
        'resource' => 'theme_hooks_01',
        'name' => 'Theme Hooks',
    ],

    'theme_customizer_01' => [
        'type' => 'customizer',
        'resource' => 'theme_customizer_01',
        'name' => 'Theme Customizer',
    ],

];
