<?php

add_action('enqueue_block_editor_assets', static function (): void {
    wp_enqueue_style(
        'theme-editor',
        get_theme_file_uri('assets/css/editor.css'),
        [],
        wp_get_theme()->get('Version')
    );
});
