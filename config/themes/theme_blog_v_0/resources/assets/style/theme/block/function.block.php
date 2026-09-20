<?php

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'theme-style',
        get_theme_file_uri('assets/css/style.css'),
        [],
        wp_get_theme()->get('Version')
    );
});
