<?php

declare(strict_types=1);

return [

    'layout_01' => [
        'type' => [
            'name' => 'layout',
        ],
        'name' => 'Main Layout',
    ],

    'content_01' => [
        'type' => [
            'name' => 'content',
        ],
        'name' => 'Post Content',
    ],

    'query_01' => [
        'type' => [
            'name' => 'query',
        ],
        'name' => 'Posts Query',
    ],

    'navigation_01' => [
        'type' => [
            'name' => 'component',
        ],
        'name' => 'Primary Navigation',
    ],

    'site_title_01' => [
        'type' => [
            'name' => 'component',
        ],
        'name' => 'Site Title',
    ],

    'archive_title_01' => [
        'type' => [
            'name' => 'component',
        ],
        'name' => 'Archive Title',
    ],

    'page_title_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'custom',
        ],
        'name' => 'Page Title',
    ],

    'post_title_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'cached',
        ],
        'name' => 'Post Title',
    ],

    'copyright_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'readonly',
        ],
        'name' => 'Copyright',
    ],

    'widgets_01' => [
        'type' => [
            'name' => 'component',
        ],
        'name' => 'Widget Area',
    ],

];
