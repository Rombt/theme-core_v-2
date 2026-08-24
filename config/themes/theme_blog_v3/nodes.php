<?php

declare(strict_types=1);

return [

    'post_content_01' => [
        'type' => [
            'name' => 'content',
        ],
        'rendering' => 'template-part',
        'resource' => 'post_content_01',
        'name' => 'Post Content',
    ],

    'page_content_01' => [
        'type' => [
            'name' => 'content',
        ],
        'rendering' => 'template-part',
        'resource' => 'page_content_01',
        'name' => 'Page Content',
    ],

    'no_posts_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'default',
        ],
        'rendering' => 'template-part',
        'resource' => 'no_posts_01',
        'name' => 'No Posts',
    ],

    'navigation_01' => [
        'type' => [
            'name' => 'component',
        ],
        'rendering' => 'inline',
        'resource' => 'navigation_01',
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
        'resource' => 'footer_navigation_01',
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
        'resource' => 'hero_navigation_01',
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
        'resource' => 'site_title_01',
        'name' => 'Site Title',
    ],

    'archive_title_01' => [
        'type' => [
            'name' => 'component',
        ],
        'rendering' => 'inline',
        'resource' => 'archive_title_01',
        'name' => 'Archive Title',
    ],

    'page_title_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'custom',
        ],
        'rendering' => 'template-part',
        'resource' => 'page_title_01',
        'name' => 'Page Title',
    ],

    'post_title_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'cached',
        ],
        'rendering' => 'template-part',
        'resource' => 'post_title_01',
        'name' => 'Post Title',
    ],

    'copyright_01' => [
        'type' => [
            'name' => 'component',
            'strategy' => 'readonly',
        ],
        'rendering' => 'inline',
        'resource' => 'copyright_01',
        'name' => 'Copyright',
    ],

    'widgets_01' => [
        'type' => [
            'name' => 'component',
        ],
        'rendering' => 'inline',
        'resource' => 'widgets_01',
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
