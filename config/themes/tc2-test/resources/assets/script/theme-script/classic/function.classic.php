<?php
add_action('wp_enqueue_scripts', static function (): void {
    $theme = wp_get_theme();

    wp_enqueue_script(
        get_stylesheet() . '-theme',
        get_theme_file_uri('assets/js/main-scripts.js'),
        [],
        $theme->get('Version'),
        true
    );
});
