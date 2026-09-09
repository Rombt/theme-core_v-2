<?php

return [

    'setup' => [
        'type' => 'setup',
        'resource' => 'theme_setup',
        'name' => 'Theme Setup',
        'configuration' => [
            'order' => 20,
        ],
    ],

    'theme_hooks_01' => [
        'type' => 'hook',
        'resource' => 'theme_hooks_01',
        'name' => 'Theme Hooks',
        'configuration' => [
            'order' => 25,
        ],
    ],

    'theme_customizer_01' => [
        'type' => 'customizer',
        'resource' => 'theme_customizer_01',
        'name' => 'Theme Customizer',
        'configuration' => [
            'order' => 70,
        ],
    ],

];
