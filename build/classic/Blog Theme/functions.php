<?php

declare(strict_types=1);

add_action('after_setup_theme', static function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('custom-background');
    add_theme_support('custom-header');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5');
    add_theme_support('post-formats');

    add_image_size('featured-large', 1200, 800, true);
    add_image_size('featured-medium', 800, 533, true);
    add_image_size('featured-small', 400, 267, true);

    load_theme_textdomain('blog-theme');

    $GLOBALS['content_width'] = 1200;
});

register_nav_menu(
    'primary',
    'Primary Menu',
);

register_nav_menu(
    'footer',
    'Footer Menu',
);

register_nav_menu(
    'hero',
    'Hero Menu',
);
