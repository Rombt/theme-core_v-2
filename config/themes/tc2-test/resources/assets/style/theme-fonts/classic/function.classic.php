<?php
add_action('wp_enqueue_scripts', static function (): void {
    $theme = wp_get_theme();

    wp_enqueue_style(
        get_stylesheet() . '-fonts',
        get_theme_file_uri('assets/style/fonts.css'),
        [],
        $theme->get('Version')
    );
});
