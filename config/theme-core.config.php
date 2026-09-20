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


            // 'relative' => 'build/themes',
            // 'absolute' => 'C:/local.wp/wp-content/themes',   // работа
            'absolute' => 'D:\web\multisite\wp-content\themes',   // дом

            // 'base' => 'wordpress',
            // 'path' => 'wp-content/themes',

        ],
    ],

    'theme' => [
        'packages_path' => 'config/themes',

        // 'package' => 'theme_1',
        // 'package' => 'theme_2',
        // 'package' => 'theme_blog',
        // 'package' => 'theme_blog_v2',
        'package' => 'theme_blog_v3',

        // 'resource_package' => 'config\themes\theme_blog_v2\resources',
        'resource_package' => 'config\themes\theme_blog_v3\resources',
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
