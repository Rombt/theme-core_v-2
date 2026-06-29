<?php

/**
 * Канал для описания всех Entity темы (Post, Author, Category, Product и т.д.).
 */

 return [
    'post' => [
        'fields' => [
            'title',
            'content',
            'excerpt',
            'date',
        ],
    ],

    'category' => [
        'fields' => [
            'name',
            'description',
            'slug',
        ],
    ],
 ];
