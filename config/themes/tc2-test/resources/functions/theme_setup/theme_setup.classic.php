<?php

/**
 * Classic Basic WordPress theme setup.
 */
function tc2_classic_basic_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo', [
        'height' => 120,
        'width' => 320,
        'flex-height' => true,
        'flex-width' => true,
    ]);

    register_nav_menus([
        'header_nav' => __('Header Navigation', wp_get_theme()->get('TextDomain')),
    ]);
}
add_action('after_setup_theme', 'tc2_classic_basic_setup');
