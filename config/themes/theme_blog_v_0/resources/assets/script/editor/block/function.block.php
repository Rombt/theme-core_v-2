<?php

add_action('enqueue_block_editor_assets', static function (): void {
    wp_enqueue_script(
        'theme-editor',
        get_theme_file_uri('assets/js/editor.js'),
        [],
        wp_get_theme()->get('Version'),
        true
    );
});
