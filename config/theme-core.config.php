<?php

return [

    'project' => [
        'name' => 'theme-core-v2',
    ],

    'environment' => [],

    'paths' => [
        'build' => 'build',
    ],

    'theme' => [
        'packages_path' => 'config/themes',
        // 'package' => 'theme_1',
        // 'package' => 'theme_2',
        'package' => 'theme_blog',
    ],

    'logging' => [
        'enabled' => true,
        'path' => 'logs/runtime.log',
    ],

    'diagnostic' => [
        'enabled' => true,
        'path' => 'logs/diagnostic.log',
    ],
];
