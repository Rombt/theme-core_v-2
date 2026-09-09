<?php

add_action('after_setup_theme', static function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('custom-background');
    add_theme_support('custom-header');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5');
    add_theme_support('post-formats');

    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('appearance-tools');

    add_image_size('featured-large', 1200, 800, true);
    add_image_size('featured-medium', 800, 533, true);
    add_image_size('featured-small', 400, 267, true);

    load_theme_textdomain('blog-theme');

    $GLOBALS['content_width'] = 1200;
});
