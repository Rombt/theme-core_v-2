<?php

return [

    'project' => [
        'name' => 'theme-core-v2',
    ],

    'environment' => [],

    'paths' => [

        // 'bases' => [
        //     'wordpress' => '../local.wp',
        // ],

        'output' => [

            'absolute' => 'F:\web\local.wp\wp-content\themes',   // работа
            // 'absolute' => 'D:\web\multisite\wp-content\themes',   // дом

            // 'relative' => 'build/themes',
            // 'base' => 'wordpress',
            // 'path' => 'wp-content/themes',

        ],
    ],

    'theme' => [
        'packages_path' => 'config/themes',
        'package' => 'theme_blog_v_1',
        'resource_package' => 'config\themes\theme_blog_v_1\resources',
        // 'package' => 'theme_blog_v_0',
        // 'resource_package' => 'config\themes\theme_blog_v_0\resources',
    ],

    'php_parser' => [
        // 'format' => 'pretty_print',
        'format' => 'format_preserving',
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
