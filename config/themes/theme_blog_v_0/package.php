<?php

/**
 * package.php является точкой входа в конфигурацию темы,
 * в нём должны быть перечислены все домены которые есть в настройках темы.
 * Обрабатывая package.php приложение получит информацию
 * о всех существующих доменах конфигурации темы и обработает их
 *
 */

return [

    // Metadata
    // при добавлении нового поля добавить его и в core\Theme\ThemeMetadataFactory.php

    'name'        => 'Blog Theme',
    'description' => 'A lightweight, accessibility-ready, and block-based WordPress theme designed for modern blogging and optimal readability.',
    'version'     => '1.0.0',
    'author'      => 'Developer Name',
    'author_uri'  => 'https://example.com/about',
    'theme_uri'   => 'https://github.com/your-username/blog-theme',
    'text_domain' => 'blog-theme',

    // Theme Specification

    'domains' => [
        'nodes'          => 'nodes.php',
        'compositions'   => 'compositions.php',
        'design-systems' => 'design-system.php',
        'assets'         => 'assets.php',
        'integrations'   => 'integrations.php',
        'functions'      => 'functions.php',
        ],

];
