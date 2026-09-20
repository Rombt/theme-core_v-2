<?php

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
