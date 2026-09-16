<?php

add_action('admin_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'theme-editor',
        get_theme_file_uri('assets/css/editor.css'),
        [],
        wp_get_theme()->get('Version')
    );
});
