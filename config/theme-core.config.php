<?php

declare(strict_types=1);

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

        'resource_package' => 'resources',
    ],

    'logging' => [
        'enabled' => true,

        'runtime_path' => 'logs/runtime.log',
        'runtime_append' => true,

        'debug_path' => 'logs/debug.log',
        'debug_append' => false,
    ],

    'diagnostic' => [
        'enabled' => true,
        'path' => 'logs/diagnostic.log',
    ],

];
