<?php

return [

    'header' => [
        'type' => 'layout',
        'resource' => 'header',
        'rendering' => 'header',

        'children' => [
            [
                'id' => 'site-title',
                'node' => 'site_title_01',
                'slot' => 1,
            ],
            [
                'id' => 'navigation',
                'node' => 'navigation_01',
                'slot' => 2,
            ],
            [
                'id' => 'id_hero_navigation_01',
                'node' => 'hero_navigation_01',
                'slot' => 2,
            ],
        ],
    ],

    'footer' => [
        'type' => 'layout',
        'resource' => 'footer',
        'rendering' => 'footer',

        'children' => [
            [
                'id' => 'copyright',
                'node' => 'copyright_01',
                'slot' => 2,
            ],
            [
                'id' => 'id_footer_navigation_01',
                'node' => 'footer_navigation_01',
                'slot' => 1,
            ],
        ],
    ],

    'sidebar' => [
        'type' => 'layout',
        'resource' => 'sidebar_01',
        'rendering' => 'sidebar',

        'children' => [
            [
                'id' => 'widgets',
                'node' => 'widgets_01',
            ],
        ],
    ],

    'layout' => [
        'type' => 'layout',
        'resource' => 'layout_01',
        'rendering' => 'template-part',

        'children' => [
            [
                'id' => 'post-loop',
                'composition' => 'post-loop',
                'slot' => 1,
            ],
            [
                'id' => 'sidebar',
                'composition' => 'sidebar',
                'slot' => 2,
            ],
        ],
    ],

    'post-loop' => [
        'type' => 'post',
        'resource' => 'post_loop_01',
        'rendering' => 'template-part',

        'children' => [
            [
                'id' => 'post-title',
                'node' => 'post_title_01',
                'slot' => 1,
            ],
            [
                'id' => 'no-posts',
                'node' => 'no_posts_01',
                'slot' => 2,
            ],
        ],
    ],

    'index' => [
        'type' => 'template',
        'rendering' => 'template',
        'resource' => 'index',

        'children' => [
            [
                'id' => 'header',
                'composition' => 'header',
            ],
            [
                'id' => 'layout',
                'composition' => 'layout',
            ],
            [
                'id' => 'footer',
                'composition' => 'footer',
            ],
        ],
    ],

    'single' => [
        'type' => 'template',
        'rendering' => 'template',
        'resource' => 'single',

        'children' => [
            [
                'id' => 'header',
                'composition' => 'header',
            ],
            [
                'id' => 'layout',
                'composition' => 'layout',

                'children' => [
                    [
                        'id' => 'post-title',
                        'node' => 'post_title_01',
                        'slot' => 1,
                    ],
                    [
                        'id' => 'post-content',
                        'node' => 'post_content_01',
                        'slot' => 2,
                    ],
                    [
                        'id' => 'sidebar',
                        'composition' => 'sidebar',
                        'slot' => 3,
                    ],
                ],
            ],
            [
                'id' => 'footer',
                'composition' => 'footer',
            ],
        ],
    ],

    'page' => [
        'type' => 'template',
        'rendering' => 'template',
        'resource' => 'page',

        'children' => [
            [
                'id' => 'header',
                'composition' => 'header',
            ],
            [
                'id' => 'layout',
                'composition' => 'layout',

                'children' => [
                    [
                        'id' => 'page-title',
                        'node' => 'page_title_01',
                        'slot' => 1,
                    ],
                    [
                        'id' => 'page-content',
                        'node' => 'page_content_01',
                        'slot' => 2,
                    ],
                    [
                        'id' => 'sidebar',
                        'composition' => 'sidebar',
                        'slot' => 3,
                    ],
                ],
            ],
            [
                'id' => 'footer',
                'composition' => 'footer',
            ],
        ],
    ],

    'category' => [
        'type' => 'template',
        'rendering' => 'template',
        'resource' => 'category',

        'children' => [
            [
                'id' => 'header',
                'composition' => 'header',
            ],
            [
                'id' => 'layout',
                'composition' => 'layout',

                'children' => [
                    [
                        'id' => 'archive-title',
                        'node' => 'archive_title_01',
                        'slot' => 1,
                    ],
                    [
                        'id' => 'post-loop',
                        'composition' => 'post-loop',
                        'slot' => 2,
                    ],
                    [
                        'id' => 'sidebar',
                        'composition' => 'sidebar',
                        'slot' => 3,
                    ],
                ],
            ],
            [
                'id' => 'footer',
                'composition' => 'footer',
            ],
        ],
    ],

    'tag' => [
        'type' => 'template',
        'rendering' => 'template',
        'resource' => 'tag',

        'children' => [
            [
                'id' => 'header',
                'composition' => 'header',
            ],
            [
                'id' => 'layout',
                'composition' => 'layout',

                'children' => [
                    [
                        'id' => 'archive-title',
                        'node' => 'archive_title_01',
                        'slot' => 1,
                    ],
                    [
                        'id' => 'post-loop',
                        'composition' => 'post-loop',
                        'slot' => 2,
                    ],
                    [
                        'id' => 'sidebar',
                        'composition' => 'sidebar',
                        'slot' => 3,
                    ],
                ],
            ],
            [
                'id' => 'footer',
                'composition' => 'footer',
            ],
        ],
    ],

    'query' => [
        'type' => 'post',
        'resource' => 'query_01',
        'rendering' => 'template-part',

        'children' => [
            [
                'id' => 'post',
                'node' => 'post_title_01',
                'slot' => 1,
            ],
            [
                'id' => 'no-posts',
                'node' => 'no_posts_01',
                'slot' => 2,
            ],
        ],
    ],

];
