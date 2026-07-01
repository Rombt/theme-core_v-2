<?php

declare(strict_types=1);

return [

    'header' => [
        'type' => 'template-part',

        'children' => [
            'site-title',
            'navigation',
        ],
    ],

    'footer' => [
        'type' => 'template-part',

        'children' => [
            'copyright',
        ],
    ],

    'sidebar' => [
        'type' => 'template-part',

        'children' => [
            'widgets',
        ],
    ],

    'index' => [
        'type' => 'template',

        'children' => [
            'header',

            [
                'id' => 'layout',

                'children' => [

                    [
                        'id' => 'content',

                        'children' => [
                            'page-title',
                            'post-loop',
                        ],
                    ],

                    'sidebar',
                ],
            ],

            'footer',
        ],
    ],

    'single' => [
        'type' => 'template',

        'children' => [
            'header',

            [
                'id' => 'layout',

                'children' => [

                    [
                        'id' => 'content',

                        'children' => [
                            'post-title',
                            'post-content',
                        ],
                    ],

                    'sidebar',
                ],
            ],

            'footer',
        ],
    ],

    'category' => [
        'type' => 'template',

        'children' => [
            'header',

            [
                'id' => 'layout',

                'children' => [

                    [
                        'id' => 'content',

                        'children' => [
                            'archive-title',
                            'post-loop',
                        ],
                    ],

                    'sidebar',
                ],
            ],

            'footer',
        ],
    ],

    'tag' => [
        'type' => 'template',

        'children' => [
            'header',

            [
                'id' => 'layout',

                'children' => [

                    [
                        'id' => 'content',

                        'children' => [
                            'archive-title',
                            'post-loop',
                        ],
                    ],

                    'sidebar',
                ],
            ],

            'footer',
        ],
    ],

];
