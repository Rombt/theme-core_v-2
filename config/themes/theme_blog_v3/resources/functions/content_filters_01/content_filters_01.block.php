<?php

add_filter('the_content', static function (string $content): string {
    return $content;
});

add_filter('the_excerpt', static function (string $excerpt): string {
    return $excerpt;
});
