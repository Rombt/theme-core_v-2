<?php

return [

    'page' => [
        'type' => 'page',
        'rendering' => 'template-part',
        'resource' => 'page',

        'children' => [
            [
                'id' => 'header',
                'composition' => 'header',
                'slot' => 1,
            ],
            [
                'id' => 'footer',
                'composition' => 'footer',
                'slot' => 3,
            ],
        ],
    ],

    'header' => [
        'type' => 'section',
        'rendering' => 'template-part',
        'resource' => 'header',

        'children' => [
            [
                'id' => 'site-title',
                'node' => 'site-title',
                'slot' => 1,
            ],
            [
                'id' => 'primary-navigation',
                'node' => 'primary-navigation',
                'slot' => 2,
            ],
        ],
    ],



    'footer' => [
        'type' => 'section',
        'rendering' => 'template-part',
        'resource' => 'footer',

        'children' => [
            [
                'id' => 'footer-navigation',
                'node' => 'footer-navigation',
                'slot' => 1,
            ],
            [
                'id' => 'copyright',
                'node' => 'copyright',
                'slot' => 2,
            ],
        ],
    ],

];
