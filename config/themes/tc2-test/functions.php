<?php

declare(strict_types=1);

return [
    'helpers' => [
        'type' => 'helper',
        'resource' => 'helpers',
        'name' => 'Theme Helpers',
        'configuration' => [
            'order' => 5,
        ],
    ],
    'setup' => [
        'type' => 'setup',
        'resource' => 'theme_setup',
        'name' => 'Theme Setup',
        'configuration' => [
            'order' => 10,
        ],
    ],
];
