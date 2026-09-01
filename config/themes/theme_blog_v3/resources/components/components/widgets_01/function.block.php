<?php

register_sidebar(
    [
        'id'            => 'primary-sidebar',
        'name'          => 'Primary Sidebar',
        'description'   => 'Main sidebar displayed on posts and pages.',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ],
);
