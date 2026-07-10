<?php

declare(strict_types=1);

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style('theme');
    wp_enqueue_style('editor');
    wp_enqueue_script('frontend');
    wp_enqueue_script('editor-js');
});
