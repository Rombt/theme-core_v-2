<?php

declare(strict_types=1);

return [

    'header' => [
        'type' => 'template-part',
    ],

    'footer' => [
        'type' => 'template-part',
    ],

    'sidebar' => [
        'type' => 'template-part',
    ],

    'index' => [
        'type' => 'template',

        'children' => [
            'header',
            'content',
            'sidebar',
            'footer',
        ],
    ],

    'single' => [
        'type' => 'template',

        'children' => [
            'header',
            'content',
            'sidebar',
            'footer',
        ],
    ],

    'category' => [
        'type' => 'template',

        'children' => [
            'header',
            'content',
            'sidebar',
            'footer',
        ],
    ],

    'tag' => [
        'type' => 'template',

        'children' => [
            'header',
            'content',
            'sidebar',
            'footer',
        ],
    ],

];
