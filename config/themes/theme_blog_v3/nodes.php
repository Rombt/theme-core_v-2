<?php

return [

    'post_content_01' => [
        'type' => 'post',
        'rendering' => 'template-part',
        'resource' => 'post_content_01',
        'name' => 'Post Content',
    ],

    'page_content_01' => [
        'type' => 'page',
        'rendering' => 'template-part',
        'resource' => 'page_content_01',
        'name' => 'Page Content',
    ],

    'no_posts_01' => [
        'type' => 'common',
        'rendering' => 'template-part',
        'resource' => 'no_posts_01',
        'name' => 'No Posts',
    ],

    'navigation_01' => [
        'type' => 'navigation',
        'rendering' => 'inline',
        'resource' => 'navigation_01',
        'name' => 'Primary Navigation',

        'function' => [
            'enabled' => true,
            'order' => 50,
        ],
    ],

    'footer_navigation_01' => [
        'type' => 'navigation',
        'rendering' => 'inline',
        'resource' => 'footer_navigation_01',
        'name' => 'Footer Navigation',

        'function' => [
            'enabled' => true,
            'order' => 50,
        ],
    ],

    'hero_navigation_01' => [
        'type' => 'navigation',
        'rendering' => 'inline',
        'resource' => 'hero_navigation_01',
        'name' => 'Hero Navigation',

        'function' => [
            'enabled' => true,
            'order' => 50,
        ],
    ],

    'site_title_01' => [
        'type' => 'common',
        'rendering' => 'inline',
        'resource' => 'site_title_01',
        'name' => 'Site Title',
    ],

    'archive_title_01' => [
        'type' => 'common',
        'rendering' => 'inline',
        'resource' => 'archive_title_01',
        'name' => 'Archive Title',
    ],

    'page_title_01' => [
        'type' => 'page',
        'rendering' => 'template-part',
        'resource' => 'page_title_01',
        'name' => 'Page Title',
    ],

    'post_title_01' => [
        'type' => 'post',
        'rendering' => 'template-part',
        'resource' => 'post_title_01',
        'name' => 'Post Title',
    ],

    'copyright_01' => [
        'type' => 'common',
        'rendering' => 'inline',
        'resource' => 'copyright_01',
        'name' => 'Copyright',
    ],

    'widgets_01' => [
        'type' => 'common',
        'rendering' => 'inline',
        'resource' => 'widgets_01',
        'name' => 'Primary Sidebar',

        'function' => [
            'enabled' => true,
            'order' => 50,
        ],
    ],

];
