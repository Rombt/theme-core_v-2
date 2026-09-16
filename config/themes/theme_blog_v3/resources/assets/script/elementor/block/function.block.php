<?php

add_action('wp_enqueue_scripts', static function (): void {
    if (!did_action('elementor/loaded')) {
        return;
    }

    wp_enqueue_script(
        'theme-elementor',
        get_theme_file_uri('assets/js/elementor.js'),
        [],
        wp_get_theme()->get('Version'),
        true
    );
});
