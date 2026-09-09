<?php

add_action('enqueue_block_editor_assets', static function (): void {
    wp_enqueue_script(
        'blog-theme-editor',
        get_template_directory_uri() . '/assets/js/editor.js',
        [],
        wp_get_theme()->get('Version'),
        true,
    );
});
