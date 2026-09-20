<?php

return [

    'site-title' => [
        'type' => 'common',
        'rendering' => 'inline',
        'resource' => 'site_title_01',
        'name' => 'Site Title',
    ],

    'primary-navigation' => [
        'type' => 'navigation',
        'rendering' => 'inline',
        'resource' => 'navigation_01',
        'name' => 'Primary Navigation',

        'function' => [
            'enabled' => true,
            'order' => 30,
        ],
    ],

    'hero-navigation' => [
        'type' => 'navigation',
        'rendering' => 'inline',
        'resource' => 'hero_navigation_01',
        'name' => 'Hero Navigation',

        'function' => [
            'enabled' => true,
            'order' => 40,
        ],
    ],

    'footer-navigation' => [
        'type' => 'navigation',
        'rendering' => 'inline',
        'resource' => 'footer_navigation_01',
        'name' => 'Footer Navigation',

        'function' => [
            'enabled' => true,
            'order' => 35,
        ],
    ],

    'copyright' => [
        'type' => 'common',
        'rendering' => 'inline',
        'resource' => 'copyright_01',
        'name' => 'Copyright',
    ],

];
