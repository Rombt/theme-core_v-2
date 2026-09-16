<?php

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_script(
        'theme-navigation',
        get_theme_file_uri('assets/js/navigation.js'),
        [],
        wp_get_theme()->get('Version'),
        true
    );
});
