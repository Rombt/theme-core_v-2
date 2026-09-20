<?php

add_filter('excerpt_length', static function (int $length): int {
    return 30;
});

add_filter('excerpt_more', static function (): string {
    return '…';
});
