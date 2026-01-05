<?php

/**
 * Theme bootstrap
 *
 * @package MyTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Theme constants
 */
define('THEME_PATH', get_template_directory());
define('THEME_URI', get_template_directory_uri());

/**
 * Core files
 */
require_once THEME_PATH . '/core/core.php';

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {

    // Поддержка Gutenberg
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Title tag
    add_theme_support('title-tag');

    // Thumbnails
    add_theme_support('post-thumbnails');

    // HTML5
    add_theme_support(
        'html5',
        [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]
    );
});
