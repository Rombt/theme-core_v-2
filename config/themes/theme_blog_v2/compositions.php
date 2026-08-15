<?php

declare(strict_types=1);

return [

    'header' => [
        'type' => 'template-part',

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
        ],
    ],

    'footer' => [
        'type' => 'template-part',

        'children' => [
            [
                'id' => 'copyright',
                'node' => 'copyright_01',
            ],
        ],
    ],

    'sidebar' => [
        'type' => 'template-part',

        'children' => [
            [
                'id' => 'widgets',
                'node' => 'widgets_01',
            ],
        ],
    ],

    'index' => [
        'type' => 'template',

        'children' => [
            [
                'id' => 'header',
            ],

            [
                'id' => 'layout',
                'node' => 'layout_01',

                'children' => [
                    [
                        'id' => 'post-loop',
                        'node' => 'post_loop_01',
                        'slot' => 1,
                    ],
                    [
                        'id' => 'sidebar',
                        'slot' => 2,
                    ],
                ],
            ],

            [
                'id' => 'footer',
            ],
        ],
    ],

    'single' => [
        'type' => 'template',

        'children' => [
            [
                'id' => 'header',
            ],

            [
                'id' => 'layout',
                'node' => 'layout_01',

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
                        'slot' => 3,
                    ],
                ],
            ],

            [
                'id' => 'footer',
            ],
        ],
    ],

    'page' => [
        'type' => 'template',

        'children' => [
            [
                'id' => 'header',
            ],

            [
                'id' => 'layout',
                'node' => 'layout_01',

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
                        'slot' => 3,
                    ],
                ],
            ],

            [
                'id' => 'footer',
            ],
        ],
    ],

    'category' => [
        'type' => 'template',

        'children' => [
            [
                'id' => 'header',
            ],

            [
                'id' => 'layout',
                'node' => 'layout_01',

                'children' => [
                    [
                        'id' => 'archive-title',
                        'node' => 'archive_title_01',
                        'slot' => 1,
                    ],
                    [
                        'id' => 'post-loop',
                        'node' => 'post_loop_01',
                        'slot' => 2,
                    ],
                    [
                        'id' => 'sidebar',
                        'slot' => 3,
                    ],
                ],
            ],

            [
                'id' => 'footer',
            ],
        ],
    ],

    'tag' => [
        'type' => 'template',

        'children' => [
            [
                'id' => 'header',
            ],

            [
                'id' => 'layout',
                'node' => 'layout_01',

                'children' => [
                    [
                        'id' => 'archive-title',
                        'node' => 'archive_title_01',
                        'slot' => 1,
                    ],
                    [
                        'id' => 'post-loop',
                        'node' => 'post_loop_01',
                        'slot' => 2,
                    ],
                    [
                        'id' => 'sidebar',
                        'slot' => 3,
                    ],
                ],
            ],

            [
                'id' => 'footer',
            ],
        ],
    ],

    'post-loop' => [
        'type' => 'template-part',

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

];
