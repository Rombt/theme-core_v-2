<?php

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
