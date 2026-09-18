<?php

add_action('after_setup_theme', static function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('custom-background');
    add_theme_support('custom-header');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5');
    add_theme_support('post-formats');

    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('appearance-tools');

    add_image_size('featured-large', 1200, 800, true);
    add_image_size('featured-medium', 800, 533, true);
    add_image_size('featured-small', 400, 267, true);

    load_theme_textdomain('blog-theme');

    $GLOBALS['content_width'] = 1200;
});

add_action('after_setup_theme', static function (): void {
    add_image_size('hero-large', 1920, 1080, true);
    add_image_size('card-large', 800, 600, true);
    add_image_size('card-medium', 600, 450, true);
    add_image_size('card-small', 400, 300, true);
});

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'blog-theme',
        get_template_directory_uri() . '/assets/css/theme.css',
        [],
        wp_get_theme()->get('Version'),
    );

    wp_enqueue_script(
        'blog-theme',
        get_template_directory_uri() . '/assets/js/frontend.js',
        [],
        wp_get_theme()->get('Version'),
        true,
    );
});

register_nav_menu(
    'primary',
    'Primary Menu',
);

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'theme-style',
        get_theme_file_uri('assets/css/style.css'),
        [],
        wp_get_theme()->get('Version')
    );
});

add_action('admin_enqueue_scripts', static function (): void {
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

register_nav_menu(
    'footer',
    'Footer Menu',
);

add_action('enqueue_block_editor_assets', static function (): void {
    wp_enqueue_script(
        'blog-theme-editor',
        get_template_directory_uri() . '/assets/js/editor.js',
        [],
        wp_get_theme()->get('Version'),
        true,
    );
});

register_nav_menu(
    'hero',
    'Hero Menu',
);

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

add_action('admin_enqueue_scripts', static function (): void {
    wp_enqueue_script(
        'theme-editor',
        get_theme_file_uri('assets/js/editor.js'),
        [],
        wp_get_theme()->get('Version'),
        true
    );
});

add_action('widgets_init', static function (): void {
    register_sidebar([
        'id'            => 'primary-sidebar',
        'name'          => __('Primary Sidebar', 'blog-theme'),
        'description'   => __('Main sidebar displayed on posts and pages.', 'blog-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);

    register_sidebar([
        'id'            => 'footer-sidebar',
        'name'          => __('Footer Sidebar', 'blog-theme'),
        'description'   => __('Widget area displayed in the footer.', 'blog-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);
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

add_filter('the_content', static function (string $content): string {
    return $content;
});

add_filter('the_excerpt', static function (string $excerpt): string {
    return $excerpt;
});

add_filter('excerpt_length', static function (int $length): int {
    return 30;
});

add_filter('excerpt_more', static function (): string {
    return '…';
});

add_action('init', static function (): void {
    register_block_style(
        'core/image',
        [
            'name'  => 'rounded',
            'label' => __('Rounded', 'blog-theme'),
        ],
    );

    register_block_style(
        'core/button',
        [
            'name'  => 'outline',
            'label' => __('Outline', 'blog-theme'),
        ],
    );
});
