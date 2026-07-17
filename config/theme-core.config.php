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
        'runtime_path' => 'logs/runtime.log',
        'runtime_append' => true,   // дописывать в конец файла
        'debug_path' => 'logs/debug.log',
        'debug_append' => false, // переписывать файл при каждом запуске приложения
    ],

    'diagnostic' => [
        'enabled' => true,
        'path' => 'logs/diagnostic.log',
    ],
];
