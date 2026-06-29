<?php

/**
 * Канал для описания всех Query темы (Search, RelatedPosts, LatestPosts, FeaturedPosts и т.д.).
 */

 return [
    'latest_posts' => [
        'entity' => 'post',
        'order' => 'date',
        'direction' => 'desc',
        'limit' => 10,
    ],
 ];
