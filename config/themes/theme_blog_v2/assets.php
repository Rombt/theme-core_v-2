<?php

/**
 * Канал для описания Asset темы (css, js, fonts, images и т.д.).
 */

 return [

    'theme' => [
        'type' => 'style',
        'entry' => 'resources/scss/theme.scss',
    ],

    'editor' => [
        'type' => 'style',
        'entry' => 'resources/scss/editor.scss',
    ],

    'frontend' => [
        'type' => 'script',
        'entry' => 'resources/js/frontend.js',
        'dependencies' => [],
    ],

    'editor-js' => [
        'type' => 'script',
        'entry' => 'resources/js/editor.js',
        'dependencies' => [
            'frontend',
        ],
    ],

 ];
