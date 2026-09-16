<?php

add_action('admin_enqueue_scripts', static function (): void {
    wp_enqueue_script(
        'theme-editor',
        get_theme_file_uri('assets/js/editor.js'),
        [],
        wp_get_theme()->get('Version'),
        true
    );
});
