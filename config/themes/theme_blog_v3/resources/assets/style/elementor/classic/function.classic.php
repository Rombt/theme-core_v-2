<?php

add_action('wp_enqueue_scripts', static function (): void {
    if (!did_action('elementor/loaded')) {
        return;
    }

    wp_enqueue_style(
        'theme-elementor',
        get_theme_file_uri('assets/css/elementor.css'),
        [],
        wp_get_theme()->get('Version')
    );
});
