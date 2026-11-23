<?php

declare(strict_types=1);

return [
    'index' => [
        'type' => 'template',
        'rendering' => 'template',
        'resource' => 'index',
        'children' => [
            ['id' => 'header', 'composition' => 'header', 'slot' => 1],
            ['id' => 'footer', 'composition' => 'footer', 'slot' => 10],
        ],
    ],
    'header' => [
        'type' => 'layout',
        'rendering' => 'header',
        'resource' => 'header',
        'children' => [
            ['id' => 'site-logo', 'node' => 'site-logo', 'slot' => 1],
            ['id' => 'primary-navigation', 'node' => 'primary-navigation', 'slot' => 2],
        ],
    ],
    'footer' => [
        'type' => 'layout',
        'rendering' => 'footer',
        'resource' => 'footer',
    ],
];
