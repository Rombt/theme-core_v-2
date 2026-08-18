<?php

declare(strict_types=1);

return [

    'post_content_01' => [
        'type' => [
            'name' => 'content',
        ],
        'rendering' => 'template-part',
        'name' => 'Post Content',
    ],

    'page_content_01' => [
        'type' => [
            'name' => 'content',
        ],
        'rendering' => 'template-part',
        'name' => 'Page Content',
    ],

    'navigation_01' => [
        'type' => [
            'name' => 'component',
        ],
        'rendering' => 'inline',
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
        'rendering' => 'inline',
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
        'rendering' => 'inline',
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
        'rendering' => 'inline',
        'name' => 'Site Title',
    ],

    'archive_title_01' => [
        'type' => [
            'name' => 'component',
        ],
        'rendering' => 'inline',
        'name' => 'Archive Title',
    ],

    'page_title_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'custom',
        ],
        'rendering' => 'template-part',
        'name' => 'Page Title',
    ],

    'post_title_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'cached',
        ],
        'rendering' => 'template-part',
        'name' => 'Post Title',
    ],

    'copyright_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'readonly',
        ],
        'rendering' => 'inline',
        'name' => 'Copyright',
    ],

    'widgets_01' => [
        'type' => [
            'name' => 'component',
        ],
        'rendering' => 'inline',
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
