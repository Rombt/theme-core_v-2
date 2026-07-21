<?php

/**
 * Post Content
 *
 * Отображает содержимое текущей записи.
 */

 declare(strict_types=1);

if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php the_content(); ?>

            <?php
            wp_link_pages([
                'before' => '<nav class="page-links">',
                'after'  => '</nav>',
            ]);
            ?>

        </article>

        <?php
    }
}
