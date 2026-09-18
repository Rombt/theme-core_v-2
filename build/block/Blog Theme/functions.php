<?php

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'theme-style',
        get_theme_file_uri('assets/css/style.css'),
        [],
        wp_get_theme()->get('Version')
    );
});

add_action('enqueue_block_editor_assets', static function (): void {
    wp_enqueue_style(
        'theme-editor',
        get_theme_file_uri('assets/css/editor.css'),
        [],
        wp_get_theme()->get('Version')
    );
});

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

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_script(
        'theme-script',
        get_theme_file_uri('assets/js/theme.js'),
        [],
        wp_get_theme()->get('Version'),
        true
    );
});

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_script(
        'theme-navigation',
        get_theme_file_uri('assets/js/navigation.js'),
        [],
        wp_get_theme()->get('Version'),
        true
    );
});

add_action('enqueue_block_editor_assets', static function (): void {
    wp_enqueue_script(
        'theme-editor',
        get_theme_file_uri('assets/js/editor.js'),
        [],
        wp_get_theme()->get('Version'),
        true
    );
});

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
