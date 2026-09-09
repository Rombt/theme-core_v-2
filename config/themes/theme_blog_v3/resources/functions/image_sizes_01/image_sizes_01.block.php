<?php

add_action('after_setup_theme', static function (): void {
    add_image_size('hero-large', 1920, 1080, true);
    add_image_size('card-large', 800, 600, true);
    add_image_size('card-medium', 600, 450, true);
    add_image_size('card-small', 400, 300, true);
});
