<?php

return [

    'index' => [
        'type' => 'page',
        'rendering' => 'template',
        'resource' => 'index',

        'children' => [
            [
                'id' => 'header',
                'composition' => 'header',
                'slot' => 1,
            ],
            [
                'id' => 'footer',
                'composition' => 'footer',
                'slot' => 10,
            ],
        ],
    ],

    'header' => [
        'type' => 'section',
        'rendering' => 'header',
        'resource' => 'header',

        'children' => [
            // [
            //     'id' => 'site-title',
            //     'node' => 'site-title',
            //     'slot' => 1,
            // ],
            // [
            //     'id' => 'primary-navigation',
            //     'node' => 'primary-navigation',
            //     'slot' => 2,
            // ],
        ],
    ],



    'footer' => [
        'type' => 'section',
        'rendering' => 'footer',
        'resource' => 'footer',

        // 'children' => [
        //     [
        //         'id' => 'footer-navigation',
        //         'node' => 'footer-navigation',
        //         'slot' => 1,
        //     ],
        //     [
        //         'id' => 'copyright',
        //         'node' => 'copyright',
        //         'slot' => 2,
        //     ],
        // ],
    ],

];
