<?php

return [

    'layout_01' => [
        'type' => [
            'name' => 'layout',
        ],
        'name' => 'Main Layout',
    ],

    'post_content_01' => [
        'type' => [
            'name' => 'content',
        ],
        'name' => 'Post Content',
    ],

    'page_content_01' => [
        'type' => [
            'name' => 'content',
        ],
        'name' => 'Page Content',
    ],

    'query_01' => [
        'type' => [
            'name' => 'query',
        ],
        'name' => 'Posts Query',
    ],

    'post_loop_01' => [
        'type' => [
            'name' => 'query',
        ],
        'name' => 'Post Loop',
    ],

    'navigation_01' => [
        'type' => [
            'name' => 'component',
        ],

        'name' => 'Primary Navigation',

        'menu' => [
            'location' => 'primary',
            'label'    => 'Primary Menu',
        ],
    ],

    'footer_navigation_01' => [
        'type' => [
            'name' => 'component',
        ],

        'name' => 'Footer Navigation',

        'menu' => [
            'location' => 'footer',
            'label'    => 'Footer Menu',
        ],
    ],

    'hero_navigation_01' => [
        'type' => [
            'name' => 'component',
        ],

        'name' => 'Hero Navigation',

        'menu' => [
            'location' => 'hero',
            'label'    => 'Hero Menu',
        ],
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

        'name' => 'Primary Sidebar',

        'sidebar' => [
            'id'            => 'primary-sidebar',
            'name'          => 'Primary Sidebar',
            'description'   => 'Main sidebar displayed on posts and pages.',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ],
    ],


];
