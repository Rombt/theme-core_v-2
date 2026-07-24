<?php

/**
 * Posts Query
 *
 * Выполняет стандартный WordPress Loop.
 */

declare(strict_types=1);

if (have_posts()) :
    while (have_posts()) :
        the_post();

        get_template_part(
            'resources/content/content_01/content'
        );
    endwhile;

    the_posts_navigation();
else :
    get_template_part(
        'template-parts/content',
        'none'
    );
endif;
