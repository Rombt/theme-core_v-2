<?php

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'blog-theme',
        get_template_directory_uri() . '/assets/css/theme.css',
        [],
        wp_get_theme()->get('Version'),
    );

    wp_enqueue_script(
        'blog-theme',
        get_template_directory_uri() . '/assets/js/frontend.js',
        [],
        wp_get_theme()->get('Version'),
        true,
    );
});
