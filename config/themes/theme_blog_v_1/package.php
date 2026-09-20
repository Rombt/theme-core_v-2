<?php

/**
 * Theme configuration package entry point.
 *
 * Defines theme metadata and the Theme Specification domains
 * available in this configuration package.
 */

return [

    // Metadata

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


        /* === пока пустые === */
        'design-systems' => 'design-system.php',
        'assets'         => 'assets.php',
        'integrations'   => 'integrations.php',
        'functions'      => 'functions.php',
    ],

];
