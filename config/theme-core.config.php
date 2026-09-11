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
        // 'package' => 'theme_blog',
        // 'package' => 'theme_blog_v2',
        'package' => 'theme_blog_v3',

        // 'resource_package' => 'config\themes\theme_blog_v2\resources',
        'resource_package' => 'config\themes\theme_blog_v3\resources',
    ],

    'php_parser' => [
        'format' => 'pretty_print',
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
